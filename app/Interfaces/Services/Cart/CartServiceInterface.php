<?php  


namespace App\Interfaces\Services\Cart;



interface CartServiceInterface{
    public function add($request);
    public function index();
    public function getUser();
    
    public function update($request , $rowId);
    public function remove($rowId);
    public function clear();
}