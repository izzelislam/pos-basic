<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    

    protected $fillable=['name','pricce','stok'];

    public function order_details()
    {
    	return $this->hasMany(OrderDetail::class);
    }
}
