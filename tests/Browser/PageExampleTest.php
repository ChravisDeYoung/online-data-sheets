<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PageExampleTest extends DuskTestCase
{
    use DatabaseMigrations;

    /* @test */
    public function register_new_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('register')
                ->type('name', 'Test User')
                ->type('email', '')
                ->type('password', '')
                ->type('password_confirmation', '')
                ->screenshot('register')
                ->press('Register')
                ->assertAuthenticated()
                ->assertRouteIs('dashboards.index');
        });
    }
}
