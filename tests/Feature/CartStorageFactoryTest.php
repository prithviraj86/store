<?php

namespace Tests\Feature;

use App\Libraries\DBStorage;
use App\Libraries\SessionStorage;
use App\Models\User;
use App\Libraries\CartStorageFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartStorageFactoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDBStorageInstance()
    {
        $user=User::find(1);
        $cartfactory=new CartStorageFactory();
        $dbstorage=$cartfactory->getStorage($user);
        //dd($dbstorage);
        $this->assertInstanceOf(DBStorage::class, $dbstorage);
    }
    public function testSessionStorageInstance()
    {

        $cartfactory=new CartStorageFactory();
        $sessionstorage=$cartfactory->getStorage();
        //dd($dbstorage);
        $this->assertInstanceOf(SessionStorage::class, $sessionstorage);
    }

}
