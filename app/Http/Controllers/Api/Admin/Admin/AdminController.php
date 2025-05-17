<?php

namespace App\Http\Controllers\Api\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Services\Admin\AdminServiceInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $adminService;
    public function __construct(AdminServiceInterface $adminService){
        $this->adminService = $adminService;
    }
    public function index()
    {
        //
        return $this->adminService->index();
    }
    public function store(RegisterRequest $request)
    {
        //
        return $this->adminService->store($request);
    }
    public function show(string $id)
    {
        //
        return $this->adminService->show($id);
    }
}
