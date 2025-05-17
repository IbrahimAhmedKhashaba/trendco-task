<?php

namespace App\Repositories\User;

use App\Interfaces\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use App\Traits\ImageManagementTrait;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    use ImageManagementTrait;
    public function index()
    {
        return User::user()->with('image')->get();
    }
    public function show($id)
    {
        return User::user()->with('image')->find($id);
    }
    public function store($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => 0,
            'email_verified_at' => now(),
        ]);

        $fileName = $this->uploadImageToDisk($data['image'], 'users');

        $user->image()->create([
            'url' => $fileName,
            'alt_text' => $data['name'] . ' Avatar',
        ]);

        return $user;
    }

    public function update($user, $data)
    {
        $user->update([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
        ]);
        if(isset($data['password'])){
            Hash::make($data['password']);
        }
        if (isset($data['image'])) {
            $this->deleteImageFromDisk('uploads/users/' . $user->image->url);
            $fileName = $this->uploadImageToDisk($data['image'], 'users');
            $oldImage = $user->image;
            $oldImage->delete();
            $user->image()->create([
                'url' => $fileName,
                'alt_text' => $data['name'] . ' Avatar',
            ]);
        }
        return $user;
    }

    public function destroy($user) {
        $this->deleteImageFromDisk('uploads/users/' . $user->image->url);
        return $user->delete();
    }
}
