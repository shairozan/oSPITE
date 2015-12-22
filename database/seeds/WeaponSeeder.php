<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Weapon;

class WeaponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Weapon::create([
            'created_by' => 1,
            'name' => 'Woodfang',
            'type' => 'Dagger',
            'die_quantity' => 2,
            'die_sides' => 4,
            'notes' => 'Created by his long lost love, Woodfang is the precursor of Ulazarin. <br> Causes long term
            neural damage to all those affected by it',
        ]);
    }
}
