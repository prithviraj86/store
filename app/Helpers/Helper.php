<?php
namespace App\Helpers;

class Helper
{

    public static function setOrBlank($value)
    {
        if(isset($value) and $value=='')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public static function setOrNotBlank($value)
    {
        if(isset($value) and $value!='')
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