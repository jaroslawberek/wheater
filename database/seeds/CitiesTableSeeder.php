<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
                'name' => "Katowice",
                'set_default'=>1
            ]);
        
        DB::table('cities')->insert([
                'name' => "Warszawa",
                'set_default'=>0
            ]);
        DB::table('cities')->insert([
                'name' => "brakbrak",
                'set_default'=>0
            ]);
    }
}
