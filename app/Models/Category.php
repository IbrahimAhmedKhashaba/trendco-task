<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Category extends Model
{
    //
    use HasTranslations;
    public $translatable = ['name' , 'description'];
    protected $fillable = ['name' , 'description' , 'status'];

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '1');
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value == '1' ? __('attrs.active') : __('attrs.inactive'),
            set: fn(string $value) => $value == 'active' ? 1 : 0,
        );
    }
}
