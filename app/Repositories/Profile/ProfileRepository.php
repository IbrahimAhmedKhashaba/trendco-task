<?php 

namespace App\Repositories\Profile;

use App\Interfaces\Repositories\Profile\ProfileRepositoryInterface;
use App\Models\User;
use App\Traits\ImageManagementTrait;
use Illuminate\Support\Facades\Hash;

class ProfileRepository implements ProfileRepositoryInterface{
    use ImageManagementTrait;
    public function show():User{
        return User::with('image')->where('id' , auth()->id())->first();
    }

    public function update($user , $data):User{
        $user->update([
            'name' => $data['name'] ?? $user->name,
        ]);

        if(isset($data['image'])){
            $this->deleteImageFromDisk('uploads/users/'.$user->image->url);
            $fileName = $this->uploadImageToDisk($data['image'], 'users');
            $user->image()->update([
                'url' => $fileName,
                'alt_text' => $user->name,
            ]);
            if(isset($data['password'])){
                $user->password = Hash::make($data['password']);
            }
            $user->save();
            
        }
        return $user;
    }
}