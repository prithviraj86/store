<?php
namespace App\Helpers;

class CartSession
{

    public static function findByKey(string $key)
    {

        if(session()->has($key))
        {
            return session()->get($key);
        }
        else
        {
            return false;
        }
    }

    public static function remove(string $key)
    {
        session()->forget($key);
        return true;
    }

    public static function add(string $key,$data)
    {
        session()->put($key,$data);

    }






}
?>