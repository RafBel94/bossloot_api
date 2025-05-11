<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\ResolveContactFormRequest;
use App\Mail\ResolveContactFormMail;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Response;
use App\Mail\ContactFormMail;
use App\Models\ContactForm;
use Illuminate\Http\Request;

class ContactController extends BaseController
{
    /**
     * Process the contact form submission and create a new contact form entry in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendContactForm(ContactFormRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $contactData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => ContactForm::STATUS_PENDING,
            ];

            // Upload the image to Cloudinary if provided
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imageUrl = Cloudinary::upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'bossloot/contact-images',
                    ]
                )->getSecurePath();
                
                $contactData['image'] = $imageUrl;
                $contactData['hasAttachment'] = true; // Attach the image to the mail
            }

            // Create the contact form entry in the database
            $contactForm = ContactForm::create($contactData);

            // Send the email
            Mail::to('rafael.beltrancaceres@gmail.com')
                ->send(new ContactFormMail($contactData, $contactData['image'] ?? null));

            DB::commit();

            return $this->sendResponse($contactForm, 'Contact form sent successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Contact form send failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Get all contact forms (for admin).
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        try {
            $contactForms = ContactForm::latest()->get();
            return $this->sendResponse($contactForms, 'Contact forms retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving contact forms: ' . $e->getMessage());
        }
    }

    /**
     * Get a specific contact form by ID (for admin).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        try {
            $contactForm = ContactForm::findOrFail($id);
            return $this->sendResponse($contactForm, 'Contact form retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving contact form: ' . $e->getMessage());
        }
    }

    /**
     * Update the status of a contact form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resolve(ResolveContactFormRequest $request, $id): JsonResponse
    {
        try {
            
            DB::beginTransaction();

            $contactForm = ContactForm::findOrFail($id);
            $contactForm->status = ContactForm::STATUS_RESOLVED;
            $contactForm->answer = $request->answer;
            $contactForm->save();

            $contactData = [
                'name' => $contactForm->name,
                'email' => $contactForm->email,
                'subject' => $contactForm->subject,
                'message' => $contactForm->message,
                'image' => $contactForm->image_url,
                'answer' => $request->answer,
            ];

            Mail::to($contactForm->email)
                ->send(new ResolveContactFormMail($contactData, $contactData['image']));

            DB::commit();
            return $this->sendResponse($contactForm, 'Contact form status and answer updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error resolving contact form: ' . $e->getMessage());
            return $this->sendError('Error resolving contact form: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete a contact form.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        try {
            $contactForm = ContactForm::findOrFail($id);
            
            if ($contactForm->image_url) {
                $publicId = $this->extractPublicIdFromUrl($contactForm->image_url);
                if ($publicId) {
                    Cloudinary::destroy($publicId);
                }
            }
            
            $contactForm->delete();
            return $this->sendResponse([], 'Contact form deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error deleting contact form: ' . $e->getMessage());
        }
    }

    /**
     * Extract public ID from Cloudinary URL.
     */
    protected function extractPublicIdFromUrl(string $url): ?string
    {
        $pattern = '/upload\/(?:v\d+\/)?([^\.]+)/';
        preg_match($pattern, $url, $matches);

        return $matches[1] ?? null;
    }
}