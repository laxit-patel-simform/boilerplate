<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'category_id'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'name');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'product_zones', 'product_id', 'zone_id');
    }
}
