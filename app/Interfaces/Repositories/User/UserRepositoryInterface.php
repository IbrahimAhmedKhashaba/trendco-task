<?php 

namespace App\Interfaces\Repositories\User;

interface UserRepositoryInterface{
    public function index();
    public function show($id);
    public function store($data);
    public function update($user , $data);
    public function destroy($id);
}