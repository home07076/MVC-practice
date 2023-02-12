<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;

    protected $fillable =[
        'name','category','size','price','quantity'
    ];

    public function Commodity_sku(){
        return $this->hasOne('App\Models\Commodity_sku' , 'commodities_id' , 'commodities_id');
    }
}

