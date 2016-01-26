<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Campaign;
use App\Weapon;

class WeaponTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testListing()
    {
        $user = User::find(1);
        $campaign = Campaign::find(1);

        $this->actingAs($user)
            ->withSession(['campaign' => $campaign,'dm'=>1])
            ->visit('/test/weapons')
            //Based on the seed data we know Woodfang will exist
            ->see('Woodfang');
    }


    public function testCreateWeapon(){
        $user = User::find(1);
        $campaign = Campaign::find(1);

        $this->actingAs($user)
            ->withSession(['campaign'=>$campaign,'dm',1])
            ->visit('/weapons/create')
            ->type('Tester','name')
            ->type('long sword', 'type')
            ->type('2','die_quantity')
            ->type('4','die_sides')
            ->type('This is a weapon created solely for application testing','notes')
            ->press('submit')
            ->visit('/test/weapons')
            ->see('Tester');
    }

    public function testUpdateWeapon(){
        $user = User::find(1);
        $campaign = Campaign::find(1);
        $weapon_id = Weapon::where('name','Tester')->max('id');

        $this->actingAs($user)
            ->withSession([
                'campaign' => $campaign,
                'dm' => 1
            ])
            ->visit('/weapons/' . $weapon_id . '/edit')
            ->type('9999','die_quantity')
            ->press('submit');

        $this->actingAs($user)
            ->withSession([
                'campaign' => $campaign,
                'dm' => 1,
            ])
            ->visit('/test/weapons')
            ->see('9999');
    }

    public function testDeleteWeapon(){
        $user = User::find(1);
        $campaign = Campaign::find(1);
        $weapon_id = Weapon::where('name','Tester')->max('id');

        $this->actingAs($user)
            ->withSession([
                'campaign'=>$campaign,
                'dm' => 1,
            ])
            ->visit('/weapons/' . $weapon_id . '/delete');

        $this->actingas($user)
            ->withSession([
                'campaign' => $campaign,
                'dm' => 1,
            ])
            ->visit('/test/weapons')
            ->dontSee('Tester');
    }

}
