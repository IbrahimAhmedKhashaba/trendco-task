<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    //

    public function getSocialiteLink($driver)
    {
        $link = Socialite::driver($driver)->stateless()->redirect()->getTargetUrl();
        return response()->apiSuccessResponse([
            'link'  => $link,
        ], ucfirst($driver).' Socialite Link');
    }
}
