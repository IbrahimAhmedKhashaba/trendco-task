<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Interfaces\Services\Profile\ProfileServiceInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    private $profileService;
    public function __construct(ProfileServiceInterface $profileService){
        $this->profileService = $profileService;
    }

    public function show(){
        return $this->profileService->show();
    }

    public function update(ProfileRequest $request){
        return $this->profileService->update($request->all());
    }
}
