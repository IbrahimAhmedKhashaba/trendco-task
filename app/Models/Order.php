<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'order_number',
        'user_id',
        'order_status',
        'payment_method',
        'payment_status',
        'city_name',
        'address_name',
        'building_number'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
