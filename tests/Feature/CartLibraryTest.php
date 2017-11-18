<?php

namespace Tests\Feature;

use App\Libraries\Cart;
use App\Libraries\CartStorageFactory;
use App\Models\User;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartLibraryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddWithLogin()
    {
        $user=User::query()->find(1);
        $cartfactory=new CartStorageFactory();
        $storage=$cartfactory->getStorage($user);
        $cart=new Cart($storage);

        $product=new Product();
        $productData=$product->findById(11);

        $this->assertEquals(1,$cart->add($productData,1));
    }
    public function testAddWithOutLogin()
    {

        $cartfactory=new CartStorageFactory();
        $storage=$cartfactory->getStorage();
        $cart=new Cart($storage);

        $product=new Product();
        $productData=$product->findById(11);
        $cart->add($productData,1);
        $data=$cart->getAll();
        $this->assertArrayHasKey('product_id',$data[11]);
        $this->assertArrayHasKey('name',$data[11]);
        $this->assertArrayHasKey('price',$data[11]);
        $this->assertArrayHasKey('quantity',$data[11]);
        $this->assertArrayHasKey('total_price',$data[11]);
    }
    public function testDecreseQuantityWithLogin()
    {
        $user=User::query()->find(1);
        $cartfactory=new CartStorageFactory();
        $storage=$cartfactory->getStorage($user);
        $cart=new Cart($storage);
        $cart->clear();
        $product=new Product();
        $productData=$product->findById(11);
        $cart->add($productData,2);
        $cart->decreseQuantity($productData);
        $data=$cart->getAll();
        $this->assertEquals(1,$data[0]['quantity']);

    }
    public function testDecreseQuantityWithOurlogin()
    {
        $cartfactory=new CartStorageFactory();
        $storage=$cartfactory->getStorage();
        $cart=new Cart($storage);

        $product=new Product();
        $cart->clear();
        $productData=$product->findById(11);
        $cart->add($productData,2);
        $cart->decreseQuantity($productData);
        $data=$cart->getAll();

        $this->assertEquals(1,$data[11]['quantity']);
    }
    public function testRemoveWithLogin()
    {
        $user=User::query()->find(1);
        $cartfactory=new CartStorageFactory();
        $storage=$cartfactory->getStorage($user);
        $cart=new Cart($storage);

        $product=new Product();
        $cart->clear();
        $productData=$product->findById(11);
        $cart->add($productData,2);
        $productData=$product->findById(10);
        $cart->add($productData,2);
        $productData=$product->findById(11);
        $cart->remove($productData);
        $data=$cart->getAll();
        //print_r($data);die;
        $this->assertArrayNotHasKey($productData->id,$data);
    }
    public function testRemoveWithOutLogin()
    {

        $cartfactory=new CartStorageFactory();
        $storage=$cartfactory->getStorage();
        $cart=new Cart($storage);

        $product=new Product();
        $cart->clear();
        $productData=$product->findById(11);
        $cart->add($productData,2);
        $productData=$product->findById(10);
        $cart->add($productData,1);
        $productData=$product->findById(11);
        $cart->remove($productData);
        $data=$cart->getAll();
        //print_r($data);die;
        $this->assertArrayNotHasKey($productData->id,$data);
    }
    public function testGetAllWithLogin()
    {
        $user=User::query()->find(1);
        $cartfactory=new CartStorageFactory();
        $storage=$cartfactory->getStorage($user);
        $cart=new Cart($storage);

        $product=new Product();
        $cart->clear();
        $productData=$product->findById(11);
        $cart->add($productData,1);
        $productData=$product->findById(10);
        $cart->add($productData,1);
        $productData=$product->findById(12);//Illuminate\Database\Eloquent\ModelNotFoundException: No query results for model [App\Models\Product] 12
        $cart->add($productData,2);
        $data=$cart->getAll();

        $this->assertGreaterThanOrEqual(0, count($data));
    }
    public function testGetAllWithOutLogin()
    {
        $cartfactory = new CartStorageFactory();
        $storage = $cartfactory->getStorage();
        $cart = new Cart($storage);

        $product = new Product();
        $cart->clear();
        $productData = $product->findById(11);
        $cart->add($productData, 3);
        $productData = $product->findById(8);
        $cart->add($productData, 2);



        $data = $cart->getAll();
        $this->assertGreaterThanOrEqual(2, count($data));

    }
}
//PHPUnit 6.4.3 by Sebastian Bergmann and contributors.
//
//......E.................                                          24 / 24 (100%)
//
//Time: 1.45 seconds, Memory: 12.00MB
//
//There was 1 error:
//
//1) Tests\Feature\CartLibraryTest::testGetAllWithLogin
//Illuminate\Database\Eloquent\ModelNotFoundException: No query results for model [App\Models\Product] 12
//
//                                                                          E:\xampp\htdocs\store\vendor\laravel\framework\src\Illuminate\Database\Eloquent\Builder.php:329
//E:\xampp\htdocs\store\app\Models\Product.php:35
//E:\xampp\htdocs\store\tests\Feature\CartLibraryTest.php:129
//
//ERRORS!
//    Tests: 24, Assertions: 37, Errors: 1.