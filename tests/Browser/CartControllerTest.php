<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CartControllerTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testindex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/cart')
                    ->assertSee('Your Cart');
        });
    }

}
