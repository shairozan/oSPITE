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
            'notes' => 'Virashathen Jiaral was at one point a servant of the woodland domain, but after several failed
            experiments with the inquisition team, he was banished from the lands and trapped in a prison world
            sandwiched between several parallel dimensions.
            <br>
            <br>
            Years passed, and eventually he found a way to reach outside of the walls of his prison to a specific
            bloodline of heroes. Those heroes were tormented via nightmares and waking dreams until finally one
            agreed to his terms in order to free him from his prison',
        ]);

        $statistics = [
            'Body' => 4,
            'Mind' => 7,
            'Soul' => 5,
        ];

        Character::create([
            'name' => 'Thunderfist McGee',
            'birthdate' => '1984-01-04',
            'race' => 'Butler',
            'gender' => 'Other',
            'alignment' => 'Lawful Good',
            'level' => 5,
            'stats' => json_encode($statistics),
            'notes' => 'Thunderfist is a mechanical butler created purely to assist Virashathen Jiaral and other
            folks <br/> Beyond that, he just sits around and cleans. Has little to no combat functionality although
            is completely impervious to all damage',
        ]);
    }
}
