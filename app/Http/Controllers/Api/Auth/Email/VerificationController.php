<?php

namespace App\Http\Controllers\Api\Auth\Email;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);

        if (hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
                event(new Verified($user));
            }

            return response()->apiSuccessResponse([
                'user' => $user,
            ] , 'Email verified successfully');
        }

        return response()->apiErrorResponse([
                'user' => $user,
            ] , 'Something Wrong, Try again!');
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->apiErrorResponse('Your Email is already verified' , 400 , [
                'user' => $user,
            ]);
        }

        $user->sendEmailVerificationNotification();

        return response()->apiSuccessResponse([
                'user' => $user,
            ], 'A new verification Email has been sent to your email' , 200);
    }
}
