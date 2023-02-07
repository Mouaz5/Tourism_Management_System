<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Mouaz Abbas',
            'email' => 'superadmin@gmail.com',
            'Mobile' => '0938249138',
            'password' => bcrypt('123456a'),
            'card_number' => '3071563',
            'created_at' => '2020-09-01 21:18:10.000000',
            'updated_at' => '2020-09-01 21:18:10.000000',
        ]);
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Abdullah al-mekdad',
            'email' => 'user@gmail.com',
            'Mobile' => '09322307628',
            'card_number' => '4189275',
            'password' => bcrypt('123456b'),
            'created_at' => '2020-09-01 21:18:10.000000',
            'updated_at' => '2020-09-01 21:18:10.000000',
        ]);
    }
}
