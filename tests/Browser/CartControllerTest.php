<?php

namespace Tests\Browser;

use App\Models\User;
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
//    public function testAdd()
//    {
//        $this->browse(function (Browser $browser){
//
//            $browser->visit('/cart/store')
//                ->type('product_id', 11)
//                ->type('name', 'micromax')
//                ->type('price', 2000)
//                ->type('quantity', 2)
//                ->press('submit')
//                ->assertPathIs('/cart');
//        });
//    }
    public function testIndex()
    {


        $this->browse(function (Browser $browser) {
            $browser->visit('/cart')
                    ->assertSee('Your Shopping Cart is empty.');
        });
    }
    public function testIndexAfterLogin()
    {


        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/cart')
                    ->assertSee('Cart Items');


        });
    }

}
