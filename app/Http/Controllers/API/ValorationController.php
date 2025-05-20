<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ValorationRequest;
use App\Models\Valoration;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ValorationController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $valorations = Valoration::with(['user', 'product'])->get();

        if ($valorations->isEmpty()) {
            return $this->sendError('No valorations found.');
        }

        return $this->sendResponse($valorations, 'Valorations retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValorationRequest $request)
    {
        DB::beginTransaction();

        try {
            $imageUrl = 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745606882/valoration-placeholder_llhcse.png';
            if ($request->hasFile('image')) {
                $imageUrl = Cloudinary::upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'bossloot/valoration-images',
                    ]
                )->getSecurePath();
            }

            $userId = Auth::id();

            $valoration = Valoration::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'verified' => 0,
                'image' => $imageUrl,
            ]);

            DB::commit();

            return $this->sendResponse($valoration, 'Valoration created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error creating valoration: ' . $e->getMessage());
            return $this->sendError('Error creating valoration: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $valoration = Valoration::with(['user', 'product'])->find($id);

        if (!$valoration) {
            return $this->sendError('Valoration not found.');
        }

        return $this->sendResponse($valoration, 'Valoration retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Valoration $valoration)
    {
        //
    }

    /**
     * Verify the valoration
     */
    public function verify(String $id) {
        DB::beginTransaction();

        try {
            $valoration = Valoration::find($id);

            if (!$valoration) {
                return $this->sendError('Valoration not found.');
            }

            $valoration->verified = 1;
            $valoration->save();

            DB::commit();

            return $this->sendResponse($valoration, 'Valoration verified successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error verifying valoration: ' . $e->getMessage());
            return $this->sendError('Error verifying valoration: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValorationRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $valoration = Valoration::find($id);

            if (!$valoration) {
                return $this->sendError('Valoration not found.');
            }

            if ($request->hasFile('image')) {
                $this->deleteOldProductPicture($valoration->image);
    
                $valoration->image = Cloudinary::upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'bossloot/valoration-images',
                    ]
                )->getSecurePath();
            }

            $valoration->fill([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

            $valoration->save();

            DB::commit();

            return $this->sendResponse($valoration, 'Valoration updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error updating valoration: ' . $e->getMessage());
            return $this->sendError('Error updating valoration: ' . $e->getMessage());
        }
    }

    protected function deleteOldProductPicture(?string $url): void
    {
        // Dont delete the default image
        $defaultImage = 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745606882/valoration-placeholder_llhcse.png';

        if (empty($url) || $url === $defaultImage) {
            return;
        }

        try {
            $publicId = $this->extractPublicIdFromUrl($url);

            if ($publicId) {
                Cloudinary::destroy($publicId);
            }
        } catch (\Exception $e) {
            \Log::error("Error deleting old product picture: " . $e->getMessage());
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        DB::beginTransaction();

        try {
            $valoration = Valoration::find($id);

            if (!$valoration) {
                return $this->sendError('Valoration not found.');
            }

            $this->deleteOldProductPicture($valoration->image);

            $valoration->delete();

            DB::commit();

            return $this->sendResponse([], 'Valoration deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error deleting valoration: ' . $e->getMessage());
            return $this->sendError('Error deleting valoration: ' . $e->getMessage());
        }
    }
}
