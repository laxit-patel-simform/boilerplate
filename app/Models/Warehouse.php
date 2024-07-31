<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    public $fillable = ['name', 'code', 'zone_id'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function stock()
    {
        return $this->hasMany(WarehouseStock::class);
    }
}
