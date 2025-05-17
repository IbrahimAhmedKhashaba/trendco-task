<?php

namespace App\Http\Controllers\Api\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Interfaces\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserServiceInterface $userService){
        $this->userService = $userService;
    }
    public function index()
    {
        //
        return $this->userService->index();
    }
    public function store(UserRequest $request)
    {
        //
        return $this->userService->store($request);
    }
    public function show(string $id)
    {
        //
        return $this->userService->show($id);
    }
    public function update(UserRequest $request, string $id)
    {
        //
        return $this->userService->update($request , $id);
    }
    public function destroy(string $id)
    {
        //
        return $this->userService->destroy($id);
    }
}
