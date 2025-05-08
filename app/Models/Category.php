<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    //
    use HasTranslations;
    public $translatable = ['name' , 'description'];
    protected $fillable = ['name' , 'description' , 'status'];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '1');
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value == '1' ? 'active' : 'not active',
            set: fn (string $value) => $value == 'active' ? 1 : 0,
        );
    }
}
