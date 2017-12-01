<?php
namespace App\Helpers;

class Helper
{
    public static function set_same_key($key,$array)
    {
        $narray=array();
        foreach($array as $value)
        {
            $narray[]=array($key=>$value);
        }
        return $narray;

    }
    //This function merge array1 all value in multidimessional array all sets
    public static function merge_array_sets($array1,$array2)
    {
        $narray=array();
        foreach ($array2 as $singleArray)
        {
            $narray[]=array_merge($array1,$singleArray);
        }
        return $narray;
    }
}