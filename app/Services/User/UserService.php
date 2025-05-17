<?php

namespace App\Services\User;

use App\Http\Resources\User\UserResource;
use App\Interfaces\Repositories\User\UserRepositoryInterface;
use App\Interfaces\Services\User\UserServiceInterface;

class UserService implements UserServiceInterface
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $users = $this->userRepository->index();
        return response()->apiSuccessResponse([
            'Users' => UserResource::collection($users),
        ], __('msgs.user_all_data'));
    }
    public function show($id)
    {
        $user = $this->userRepository->show($id);
        if (!$user) {
            return response()->apiErrorResponse(__('msgs.user_not_found'), 404);
        }
        return response()->apiSuccessResponse([
            'user' => new UserResource($user),
        ], __('msgs.user_data'));
    }
    public function store($request)
    {
        try {
            $user = $this->userRepository->store($request->all());
            return response()->apiSuccessResponse([
                'User' => new UserResource($user),
            ], __('msgs.user_created'));
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }

    public function update($request, $id)
    {
        try {
            $user = $this->userRepository->show($id);
            if (!$user) {
                return response()->apiErrorResponse(__('msgs.user_not_found'), 404);
            }
            $user = $this->userRepository->update($user, $request->all());
            if (!$user) {
                return response()->apiErrorResponse(__('msgs.internal_error'), 500);
            }
            return response()->apiSuccessResponse([
                'user' => new UserResource($user),
            ], __('msgs.user_updated'));
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->userRepository->show($id);
            if (!$user) {
                return response()->apiErrorResponse(__('msgs.user_not_found'), 404);
            }
            $user = $this->userRepository->destroy($user);
            if (!$user) {
                return response()->apiErrorResponse(__('msgs.internal_error'), 500);
            }
            return response()->apiSuccessResponse([], __('msgs.user_deleted'));
        } catch (\Exception $e) {
            if (!$user) {
                return response()->apiErrorResponse(__('msgs.internal_error'), 500);
            }
        }
    }
}
