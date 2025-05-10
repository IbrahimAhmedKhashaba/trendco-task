<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


trait ImageManagementTrait
{
    //
    public function uploadImageToDisk($image , $folder)
    {
        $imageName = time() . Str::uuid() . '.' . $image->getClientOriginalExtension();
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
