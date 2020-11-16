<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table=DB::table('order_details');
        $orders=DB::table('orders')->pluck('id');
        $items=DB::table('items')->pluck('price','id');

        $table->truncate();

        foreach ($orders as $order_id) {
        	$total=0;

        	for ($item_id=1; $item_id <= rand(1,count($items)) ; $item_id++) { 
        		$qty=rand(1,10);
        		$price=$items[$item_id];
        		$subtotal=$price* $qty;
        		$total += $subtotal;

        		$table->insert([
        			'order_id'=>$order_id,
        			'item_id'=>$item_id,
        			'price'=>$price,
        			'qty'=>$qty,
        			'subtotal'=>$subtotal,
                    'created_at'=>now(),
                    'updated_at'=>now(),
        		]);
        	}
        	DB::table('orders')->where('id',$order_id)->update(['total'=>$total]);
        	
        }

        
    }
}
