<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Darrell Breeden',
            'email'=>'tester@spitedm.com',
            'password' => Hash::make('welcome'),
        ]);

        User::create([
           'name' => 'Tester Mang',
            'email' => 'user@spitedm.com',
            'password' => Hash::make('welcome'),
        ]);
    }
}
