<?php

namespace App\Services\Auth;

use App\Interfaces\Repositories\Auth\SocialiteAuthRepositoryInterface;
use App\Interfaces\Services\Auth\AuthStrategyInterface;
use App\Interfaces\Services\Auth\SocialiteAuthStrategyInterface;
use App\Models\User;
use App\Notifications\Auth\CustomVerifyEmail;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;
use Google_Client;

class SocialiteAuthService implements AuthStrategyInterface, SocialiteAuthStrategyInterface
{
    private SocialiteAuthRepositoryInterface $socialiteAuthRepository;

    public function __construct(SocialiteAuthRepositoryInterface $socialiteAuthRepository)
    {
        $this->socialiteAuthRepository = $socialiteAuthRepository;
    }

    public function register(array $data): array
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $data = [
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ];
        $this->socialiteAuthRepository->register($data);
        if (!$data) {
            return [
                'user' => false,
            ];
        }


        $user = $this->socialiteAuthRepository->register($data);
        $token = $user->createToken('google-login')->plainTextToken;
        $data['user'] = $user;
        $data['token'] = $token;

        return $data;
    }

    public function getLink()
    {
        $link = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->apiSuccessResponse([
            'link'  => $link,
        ], __('msgs.google_link'));
    }
}
