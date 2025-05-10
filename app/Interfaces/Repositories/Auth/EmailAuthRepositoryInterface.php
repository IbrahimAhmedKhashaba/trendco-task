<?php  


namespace App\Interfaces\Repositories\Auth;

use App\Models\User;

interface EmailAuthRepositoryInterface{
    public function register($data) : User;
}