<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table=DB::table('orders');
        $table->truncate();
        $table->insert([
        	'user_id' =>1,
        	'customer_name' =>'Gomet',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        $table->insert([
        	'user_id' =>1,
        	'customer_name' =>'Ajino',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        $table->insert([
        	'user_id' =>1,
        	'customer_name' =>'Moto',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
    }
}
