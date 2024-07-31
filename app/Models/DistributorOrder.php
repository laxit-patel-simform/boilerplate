<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributorOrder extends Model
{
    use HasFactory, SoftDeletes;

    private $fillable = ['distributor_id', 'status', 'tag', 'date', 'shipping_date', 'delivered_date', 'shipping_address', 'billing_address'];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(DistributorOrderItem::class, 'distributor_order_id', 'id');
    }
}
