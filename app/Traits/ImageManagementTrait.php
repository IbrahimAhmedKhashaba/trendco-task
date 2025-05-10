<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;


trait ImageManagementTrait
{
    //
    public function uploadImageToDisk($image , $folder)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('uploads/'.$folder, $imageName, ['disk' => 'uploads']);
        return $imageName;
    }

    public function deleteImageFromDisk($path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
