<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Campaign;

class CharacterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCharacterDetails()
    {
        $user = User::find(1);
        $campaign = Campaign::find(1);



        $this->actingAs($user)
            ->withSession(['campaign' => $campaign])
            ->visit('/characters/1')
            ->see('Character Details');
    }


    public function testRelationInView(){
        $user = User::find(1);
        $campaign = Campaign::find(1);

        $this->actingAs($user)
            ->withSession(['campaign'=>$campaign])
            ->visit('/characters/1')
            ->assertViewHasAll(['character']);
    }

    public function testCreateCharacter(){
        $user = User::find(1);
        $campaign = Campaign::find(1);

        $this->actingAs($user)
            ->withSession(['campaign'=>$campaign])
            ->visit('/characters/create')
            ->type('Bilbo Baggins','name')
            ->select('Male','gender')
            ->select('Lawful Good','alignment')
            ->type('Somewhat cool guy','notes')
            ->type('Strength',"#label_1")
            ->type('6','value_1')
            ->press('submit')
            ->seePageIs('/characters')
            ->see('Bilbo Baggins');
    }

}
