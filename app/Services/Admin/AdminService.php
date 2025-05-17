<?php

namespace App\Services\Admin;

use App\Http\Resources\User\UserResource;
use App\Interfaces\Repositories\Admin\AdminRepositoryInterface;
use App\Interfaces\Services\Admin\AdminServiceInterface;

class AdminService implements AdminServiceInterface
{
    private $adminRepository;
    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }
    public function index()
    {
        $admins = $this->adminRepository->index();
        return response()->apiSuccessResponse([
            'admins' => UserResource::collection($admins),
        ], __('msgs.admin_all_data'));
    }
    public function show($id)
    {
        $admin = $this->adminRepository->show($id);
        if (!$admin) {
            return response()->apiErrorResponse(__('msgs.admins_not_found'), 404);
        }
        return response()->apiSuccessResponse([
            'admin' => new UserResource($admin),
        ], __('msgs.admin_data'));
    }
    public function store($request)
    {
        try {
            $admin = $this->adminRepository->store($request->all());
            if (!$admin) {
                return response()->apiErrorResponse(__('msgs.internal_error'), 500);
            }
            return response()->apiSuccessResponse([
                'admin' => new UserResource($admin),
            ], __('msgs.admin_created'));
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }
}
