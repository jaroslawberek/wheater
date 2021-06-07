<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $faker = Faker\Factory::create();
        //$faker = Faker\Factory::create('pl_PL');

        /* Lecture 10 */
        for($i=1;$i<=2;$i++)
        {
            DB::table('users')->insert([
                'name' => $faker->firstName,
                'email' => $faker->email,
                'password' => bcrypt('1234567890'),
            ]);
        }
    }
}
