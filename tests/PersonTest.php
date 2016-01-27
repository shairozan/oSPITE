<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Campaign;
use App\Person;

class PersonTest extends TestCase
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
            ->visit('/test/people')
            //Based on the seed data we know Woodfang will exist
            ->see('Launa');
    }


    public function testCreatePerson(){
        $user = User::find(1);
        $campaign = Campaign::find(1);

        $this->actingAs($user)
            ->withSession(['campaign'=>$campaign,'dm',1])
            ->visit('/people/create')
            ->type('Tester','name')
            ->type('This is a Person created solely for application testing','notes')
            ->press('submit')
            ->visit('/test/people')
            ->see('Tester');
    }

    public function testUpdatePerson(){
        $user = User::find(1);
        $campaign = Campaign::find(1);
        $person_id = Person::where('name','Tester')->max('id');

        $this->actingAs($user)
            ->withSession([
                'campaign' => $campaign,
                'dm' => 1
            ])
            ->visit('/people/' . $person_id . '/edit')
            ->type('Jonny Test','name')
            ->press('submit');

        $this->actingAs($user)
            ->withSession([
                'campaign' => $campaign,
                'dm' => 1,
            ])
            ->visit('/test/people')
            ->see('Jonny Test');
    }

    public function testDeletePerson(){
        $user = User::find(1);
        $campaign = Campaign::find(1);
        $person_id = Person::where('name','Jonny Test')->max('id');

        $this->actingAs($user)
            ->withSession([
                'campaign'=>$campaign,
                'dm' => 1,
            ])
            ->visit('/people/' . $person_id . '/delete');

        $this->actingas($user)
            ->withSession([
                'campaign' => $campaign,
                'dm' => 1,
            ])
            ->visit('/test/people')
            ->dontSee('Jonny Test');
    }

}
