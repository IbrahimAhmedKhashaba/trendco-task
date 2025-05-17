<?php 

namespace App\Repositories\Admin;

use App\Interfaces\Repositories\Admin\AdminRepositoryInterface;
use App\Models\User;
use App\Traits\ImageManagementTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class AdminRepository implements AdminRepositoryInterface{
    use ImageManagementTrait;
    public function index():Collection{
        return User::admin()->with('image')->get();
    }
    public function show($id):?User{
        return User::admin()->where('id' , $id)->with('image')->first();
    }
    public function store($data):?User{
        $admin = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => 1,
            'email_verified_at' => now(),
        ]);

        $fileName = $this->uploadImageToDisk($data['image'], 'users');

        $admin->image()->create([
            'url' => $fileName,
            'alt_text' => $data['name'].' Avatar',
        ]);

        return $admin;
    }
}