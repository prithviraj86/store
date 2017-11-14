<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Register')
                    ->assertSee('Register')
                    ->value('#name','mohan kumar')
                    ->value('#email','mohan@gmail.com')
                    ->value('#password','12345')
                    ->value('#password-confirm','12345')
                    ->click('button[type="submit"]')
                    ->assertPathIs('/')
                    ->assertSee('STORE')
            ;
        });
    }
}
