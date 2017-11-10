<?php
namespace App\Helpers;

class Helper
{

    public static function gets($key)
    {

        return session()->get($key);
    }

    public static function remove($key)
    {
        session()->forget($key);
        return true;
    }

    public static function put($key,$data)
    {
        session()->put($key,$data);
        return true;
    }
    public static function has($key)
    {
        if(session()->has($key))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public static function responseFormat($key,array $data)
    {
        // echo $key;die;
        $return_data=array();
        if($key=='')
        {
            foreach($data as $arr)
            {
                data_set($return_data,'product_id',data_get($arr,'product_id'));
                data_set($return_data,'total_price',data_get($arr,'total_price'));

            }
        }
        else
        {
            //echo array_get($data,$key.'.total_price');die;
            data_set($return_data,'product_id',data_get($data,$key.'.product_id'));
            data_set($return_data,'total_price',data_get($data,$key.'.total_price'));

        }
        return $return_data;
    }




}
?>