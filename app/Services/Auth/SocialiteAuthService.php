<?php

namespace App\Services\Auth;

use App\Interfaces\Repositories\Auth\SocialiteAuthRepositoryInterface;
use App\Interfaces\Services\Auth\AuthStrategyInterface;
use App\Models\User;
use App\Notifications\Auth\CustomVerifyEmail;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use Google_Client;

class SocialiteAuthService implements AuthStrategyInterface
{
    private SocialiteAuthRepositoryInterface $socialiteAuthRepository;

    public function __construct(SocialiteAuthRepositoryInterface $socialiteAuthRepository)
    {
        $this->socialiteAuthRepository = $socialiteAuthRepository;
    }

    public function register(array $data): array
    {
        $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $data = $client->verifyIdToken($data['code']);
        if (!$data) {
            return [
                'user' => false,
            ];
        }


        $user = $this->socialiteAuthRepository->register($data);
        $token = $user->createToken('google-login')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}
