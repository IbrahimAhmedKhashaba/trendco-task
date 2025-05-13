<?php 

namespace App\Interfaces\Services\Admin;

interface AdminServiceInterface{
    public function index();
    public function show($id);
    public function store($request);
    public function update($request);
    public function destroy();
}