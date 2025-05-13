<?php 

namespace App\Interfaces\Repositories\Admin;

interface AdminRepositoryInterface{
    public function index();
    public function show($id);
    public function store($request);
    public function update($request);
    public function destroy();
}