<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        $this->call(UserSeeder::class);
        $this->call(CampaignSeeder::class);
        $this->call(CharacterSeeder::class);
        $this->call(WeaponSeeder::class);
        $this->call(PersonSeeder::Class);
        $this->call(RelationshipSeeder::class);

        Model::reguard();
    }
}
