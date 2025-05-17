<?php 

namespace App\Services\Profile;

use App\Http\Resources\User\UserResource;
use App\Interfaces\Repositories\Profile\ProfileRepositoryInterface;
use App\Interfaces\Services\Profile\ProfileServiceInterface;

class ProfileService implements ProfileServiceInterface{
    private $profileRepository;
    public function __construct(ProfileRepositoryInterface $profileRepository){
        $this->profileRepository = $profileRepository;
    }
    public function show(){
        try{
            $user = $this->profileRepository->show();
            return response()->apiSuccessResponse([
                'data' => new UserResource($user)
            ] , __('msgs.profile_data'));
        } catch(\Exception $e){
            return response()->apiErrorResponse( __('msgs.internal_error') , 500);
        }
    }

    public function update($data){
        try{
            $user = $this->profileRepository->show();
            $user = $this->profileRepository->update($user , $data);
            
            if(!$user){
                return response()->apiErrorResponse( __('msgs.internal_error') , 500);
            }
            return response()->apiSuccessResponse([
                'data' => new UserResource($user)
            ] , __('msgs.profile_updated'));
        } catch(\Exception $e){
            return response()->apiErrorResponse( __('msgs.internal_error') , 500);
        }
    }
}