<?php 

namespace App\Repositories\Auth;

use App\Interfaces\Repositories\Auth\EmailAuthRepositoryInterface;
use App\Models\User;
use App\Traits\ImageManagementTrait;
use Illuminate\Support\Facades\Hash;

class EmailAuthRepository implements EmailAuthRepositoryInterface{
    use ImageManagementTrait;
    public function register($data): User{
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $fileName = $this->uploadImageToDisk($data['image'], 'users');

        $user->image()->create([
            'url' => $fileName,
            'alt_text' => 'Personal Avatar',
        ]);
        return $user;
    }
}