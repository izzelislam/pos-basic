<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   

    protected $fillable=['user_id','customer_name','total'];

    public function order_details()
    {
    	return $this->hasMany(OrderDetail::class);
    }
}
