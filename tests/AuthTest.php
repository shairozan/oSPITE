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
            ->seePageIs('/')
            ->see('Character');
    }

}
