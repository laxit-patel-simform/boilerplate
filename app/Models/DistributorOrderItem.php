<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorOrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['distributor_order_id', 'product_id', 'quantity'];

    public function distributorOrder()
    {
        return $this->belongsTo(DistributorOrder::class, 'distributor_order_id', 'id');
    }
}
