<?php

namespace Tests\Unit;


use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CartControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testindex()
    {
        //    $response = $this->call('GET', '/cart');
        $this->call('get','/cart')
            ->assertViewIs('cart');
    }
    public function testStoreAfterlogin()
    {
        $user =User::find(1);

        $response = $this->actingAs($user)
            ->call('POST', '/cart/store', array(
                '_token' => csrf_token(),
                'product_id'=>8

            ));
        $response->assertStatus(500)
            ->assertRedirect('/cart');


    }
//    public function testStoreWithOutlogin()
//    {
//
//
//        $response = $this->call('POST', '/cart/store', array(
//                '_token' => csrf_token(),
//                'product_id'=>8,
//                'name'=>'Micromax smartphone',
//                'price'=>'10000'
//            ));
//        $response->assertStatus(302)
//            ->assertRedirect('/cart');
////        /print_r(session('cart'));
//
//    }
//    public function testUpdateWithOutLogin()
//    {
//
//        $response = $this->call('POST', '/cart/update', array(
//               'product_id'=>8
//        ));
//        //$response->dump();
//        $response->assertStatus(302);
//
//    }
//    public function testDelete()
//    {
//        $response=$this->call('/cart/delete',array(
//                'product_id'=>8
//            ));
//        $response->assertRedirect('/cart');
//
//    }
}
