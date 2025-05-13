<?php

namespace App\Http\Controllers\Api\Admin\Admin;

use App\Http\Controllers\Controller;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return $this->adminService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
