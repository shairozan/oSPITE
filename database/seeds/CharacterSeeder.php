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
        $statistics = [
            'Strength' => 9,
            'Constitution' => 6,
            'Dexterity' => 5,
            'Intelligence' => 9,
            'Wisdom' => 4,
            'Charisma' => 10,
        ];

        Character::create([
            'name' => 'Virashathen Jiaral',
            'birthdate' => '1976-09-22',
            'race' => 'Wood Elf',
            'gender' => 'Male',
            'alignment' => 'Lawful Good',
            'level' => 22,
            'stats' => json_encode($statistics),
            'image' => '/images/1/wood_elf.jpg',
        ]);
    }
}
