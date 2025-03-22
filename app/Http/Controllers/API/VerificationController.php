<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\URL;

class VerificationController extends BaseController
{
    /**
     * Verify the user's email.
     */
    public function verifyEmail(Request $request, $id, $hash)
    {

        $user = User::find($id);

        if (!$user) {
            return redirect('http://localhost:4200/confirm_email/notfound');
        }

        if (!URL::hasValidSignature($request)) {
            return redirect('http://localhost:4200/confirm_email/invalid');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('http://localhost:4200/confirm_email/alver');
        }

        $user->email_confirmed = true;
        $user->email_verified_at = now();
        $user->save();

        return redirect('http://localhost:4200/confirm_email/success');
    }

    /**
     * Check if an email is verified
     */
    public function checkEmailVerified(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if ($user == null) {
            return $this->sendError('User not found.');
        }

        if ($user->email_confirmed == 1) {
            return $this->sendResponse(['email_confirmed' => true], 'Email confirmed.');
        } else {
            return $this->sendError('Email not confirmed.');
        }
    }

    /**
     * Resend the email verification notification.
     */
    public function resendEmailVerificationNotification(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if ($user == null) {
            return $this->sendError('User not found.');
        }

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            return $this->sendError('Email verification error: ' . $e->getMessage());
        }

        return $this->sendResponse([], 'Email verification sent.');
    }
}
