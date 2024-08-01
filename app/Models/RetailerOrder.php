<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetailerOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['retailer_id', 'status', 'tag', 'date', 'shipping_date', 'delivered_date', 'shipping_address', 'billing_address'];

    public function retailer()
    {
        return $this->belongsTo(Retailer::class, 'retailer_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(RetailerOrderItem::class, 'retailer_order_id', 'id');
    }
}
