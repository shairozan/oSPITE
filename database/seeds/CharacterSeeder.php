<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Character;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Character::create([
            'name' => 'Virashathen Jiaral',
            'birthdate' => '1976-09-22',
            'race' => 'Wood Elf',
            'gender' => 'Male',
            'alignment' => 'Lawful Good',
            'level' => 22,
        ]);
    }
}
