<?php

namespace App\Repositories\Auth;

use App\Interfaces\Repositories\Auth\SocialiteAuthRepositoryInterface;
use App\Models\User;
use App\Traits\ImageManagementTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialiteAuthRepository implements SocialiteAuthRepositoryInterface
{
    use ImageManagementTrait;
    public function register($data): User
    {
        $user = User::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['given_name'] . ' ' . $data['family_name'],
                'provider_id' => $data['sub'],
                'image' => $data['picture'],
                'password' => bcrypt(Str::random(24)),
                'email_verified_at' => now(),
            ]
        );

        $user->image()->create([
            'url' => $data['picture'],
            'alt_text' => 'Personal Avatar',
        ]);

        return $user;
    }
}
