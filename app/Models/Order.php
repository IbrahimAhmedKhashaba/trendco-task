<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'building_number',
        'total'
    ];

    protected function paymentStatus(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value == '1' ? 'paid' : 'not paid',
            set: fn (string $value) => $value == 'active' ? 1 : 0,
        );
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
