<?php 

namespace App\Interfaces\Repositories\Profile;

use App\Models\User;

interface ProfileRepositoryInterface{
    public function show():User;
    public function update($user , $data):User;
}