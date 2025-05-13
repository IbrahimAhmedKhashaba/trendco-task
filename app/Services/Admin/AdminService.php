<?php 

namespace App\Services\Admin;

use App\Http\Resources\User\UserResource;
use App\Interfaces\Repositories\Admin\AdminRepositoryInterface;
use App\Interfaces\Services\Admin\AdminServiceInterface;

class AdminService implements AdminServiceInterface{
    private $adminRepository;
    public function __construct(AdminRepositoryInterface $adminRepository){
        $this->adminRepository = $adminRepository;
    }
    public function index(){
        $admins = $this->adminRepository->index();
        return response()->apiSuccessResponse([
            'admins' => UserResource::collection($admins),
        ] , 'Admins Data');
    }
    public function show($id){
        $admin = $this->adminRepository->show($id);
        if(!$admin){
            return response()->apiErrorResponse('Admin Not Found' , 404);
        }
        return response()->apiSuccessResponse([
            'admin' => new UserResource($admin),
        ] , 'Admin Data');
    }
    public function store($request){
        
    }
    public function update($request){
        
    }
    public function destroy(){
        
    }
}