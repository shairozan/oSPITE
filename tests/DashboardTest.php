<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Campaign;

class DashboardTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDMLogVisibility()
    {
        $user = User::find(1);
        $campaign = Campaign::find(1);

        $this->actingAs($user)
            ->withSession(['campaign' => $campaign, 'dm'=> 1])
            ->visit('/')
            ->see('Log Entry');
    }

    public function testNonDMLogVisibility(){
        $user = User::find(1);
        $campaign = Campaign::find(1);

        $this->actingAs($user)
            ->withSession(['campaign' => $campaign, 'dm'=> 0])
            ->visit('/')
            ->dontSee('Log Entry');
    }

}
