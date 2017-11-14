<?php

namespace Tests\Browser;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
//        $user = factory(User::class)->create([
//            'email' => 'prithviraj@laravel.com',
//        ]);

        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->type('email', 'prithviraj@laravel.com')
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/');
        });
    }
}
