<?php
namespace App\Libraries;


use App\Models\User;


class CartStorageFactory
{
    public static function getStorage(User $user=null)
    {
        //print_r($user);die;
        if($user)
        {
            $storage=new DBStorage();
            $storage->setUser($user);
        }
        else
        {
            $storage=new SessionStorage();
        }
        return $storage;

    }
}

?>