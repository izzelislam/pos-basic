<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    

    protected $fillable=['order_id','item_id','price','qty','subtotal'];

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function item()
    {
    	return $this->belongsTo(Item::class);
    }
}
