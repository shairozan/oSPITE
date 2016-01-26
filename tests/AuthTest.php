<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRedirect()
    {
        $this->visit('/')
            ->seePageIs('/auth/login');
    }

    public function testLoginForm()
    {
        $this->visit('/auth/login/')
            ->type('tester@spitedm.com','email')
            ->type('welcome','password')
            ->press('login')
            ->seePageIs('/');
    }

    public function testCampaignSetting(){
        //This basically tests the login handler as well
        //as the campaign middleware
        $this->visit('/auth/login')
            ->type('tester@spitedm.com','email')
            ->type('welcome','password')
            ->press('login')
            ->assertSessionHas('campaign');
    }

    public function testCampaignSessionIsTypeCampaign(){
        $this->visit('/auth/login')
            ->type('tester@spitedm.com','email')
            ->type('welcome','password')
            ->press('login');

        $this->assertInstanceOf('App\Campaign',\Session::get('campaign'));
    }

    public function testDMSetting(){
        $this->visit('/auth/login')
            ->type('tester@spitedm.com','email')
            ->type('welcome','password')
            ->press('login')
            ->assertSessionHas('campaign');
    }

    public function testDMSettingIsInteger(){
        $this->visit('/auth/login')
            ->type('tester@spitedm.com','email')
            ->type('welcome','password')
            ->press('login');

        $this->assertInternalType('integer',\Session::get('dm'));
    }

}
