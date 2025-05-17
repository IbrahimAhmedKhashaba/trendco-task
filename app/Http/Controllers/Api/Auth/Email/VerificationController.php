<?php

namespace App\Http\Controllers\Api\Auth\Email;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\UserRegistered;
use App\Http\Resources\User\UserResource;

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
            ] , __('msgs.mail_verified'));
        }

        return response()->apiErrorResponse(__('msgs.internal_error') , 500);
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->apiErrorResponse(__('msgs.mail_already_verified') , 400 , [
                'user' => new UserResource($user),
            ]);
        }

        event(new UserRegistered($user));

        return response()->apiSuccessResponse([
                'user' => new UserResource($user),
            ], __('msgs.verify_mail_send') , 200);
    }
}
