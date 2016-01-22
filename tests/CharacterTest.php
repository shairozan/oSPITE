<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Campaign;
use App\Character;

class CharacterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public $storedCharacter;

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
            ->press('submit')
            //Cleartext output of object in this campaign
            //For test purposes
            ->visit('/test/characters')
            ->see('Bilbo Baggins');
    }

    //In order to test this correctly we had to
    //create a get route for delete since hte
    //actual page used by a individual
    //uses jquery generated data. 
    public function testDeleteCharacter(){
        $user = User::find(1);
        $campaign = Campaign::find(1);
        $character_id = Character::where('name','Bilbo Baggins')->max('id');

        $this->actingAs($user)
        ->withSession(['campaign'=>$campaign])
        ->visit('/characters/' . $character_id . '/delete');

        $this->visit('/test/characters')
            ->dontSee('Bilbo Baggins');
    }

}
