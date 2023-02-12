<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity_sku extends Model
{
    use HasFactory;

    public function Commodity(){
        return $this->belongsTo(Commodity::class , 'commodities_id');
    }
}
