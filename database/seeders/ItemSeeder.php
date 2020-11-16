<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table=DB::table('items');

        $table->truncate();
        $table->insert([
        	'name'=>'neo',
        	'price'=>500,
        	'stok'=>80,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        $table->insert([
        	'name'=>'sedap',
        	'price'=>1500,
        	'stok'=>100,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        $table->insert([
        	'name'=>'sugus',
        	'price'=>500,
        	'stok'=>20,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
    }
}
