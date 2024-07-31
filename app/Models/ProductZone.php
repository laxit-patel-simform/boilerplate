<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductZone extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'zone_id', 'price'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_zones', 'product_id', 'zone_id');
    }
}
