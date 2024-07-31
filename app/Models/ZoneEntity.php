<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneEntity extends Model
{
    use HasFactory;

    public function entity()
    {
        return $this->morphTo();
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
