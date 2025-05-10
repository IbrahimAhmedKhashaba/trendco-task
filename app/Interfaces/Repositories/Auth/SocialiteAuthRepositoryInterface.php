<?php  


namespace App\Interfaces\Repositories\Auth;

use App\Models\User;

interface SocialiteAuthRepositoryInterface{
    public function register($data) : User;
}