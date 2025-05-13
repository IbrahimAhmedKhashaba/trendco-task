<?php 

namespace App\Repositories\Admin;

use App\Interfaces\Repositories\Admin\AdminRepositoryInterface;
use App\Models\User;

class AdminRepository implements AdminRepositoryInterface{
    public function index(){
        return User::admin()->with('image')->get();
    }
    public function show($id){
        return User::admin()->find($id);
    }
    public function store($request){
        
    }
    public function update($request){
        
    }
    public function destroy(){
        
    }
}