<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Campaign;
use App\Time;

class TimeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testCreateTime(){
        $user = User::find(1);
        $campaign = Campaign::find(1);

        $this->actingAs($user)
            ->withSession(['campaign'=>$campaign,'dm',1])
            ->visit('/times/create')
            ->type('Tester','name')
            ->type('This is a Time created solely for application testing','notes')
            ->press('submit')
            ->visit('/test/times')
            ->see('Tester');
    }

    public function testUpdateTime(){
        $user = User::find(1);
        $campaign = Campaign::find(1);
        $time_id = Time::where('name','Tester')->max('id');

        $this->actingAs($user)
            ->withSession([
                'campaign' => $campaign,
                'dm' => 1
            ])
            ->visit('/times/' . $time_id . '/edit')
            ->type('Jonny Test','name')
            ->press('submit');

        $this->actingAs($user)
            ->withSession([
                'campaign' => $campaign,
                'dm' => 1,
            ])
            ->visit('/test/times')
            ->see('Jonny Test');
    }

    public function testDeleteTime(){
        $user = User::find(1);
        $campaign = Campaign::find(1);
        $time_id = Time::where('name','Jonny Test')->max('id');

        $this->actingAs($user)
            ->withSession([
                'campaign'=>$campaign,
                'dm' => 1,
            ])
            ->visit('/times/' . $time_id . '/delete');

        $this->actingas($user)
            ->withSession([
                'campaign' => $campaign,
                'dm' => 1,
            ])
            ->visit('/test/times')
            ->dontSee('Jonny Test');
    }

}
