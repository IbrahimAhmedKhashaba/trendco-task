<?php 

namespace App\Interfaces\Services\Profile;

interface ProfileServiceInterface{
    public function show();
    public function update($data);
}