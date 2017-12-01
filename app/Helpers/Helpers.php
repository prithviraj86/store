<?php
use App\Helpers;
//
if (! function_exists('set_same_key')) {
    function set_same_key($key,$array)
    {
        return Helpers\Helper::set_same_key($key,$array);
    }
}
if (! function_exists('merge_array_sets')) {
    function merge_array_sets($array1,$array2)
    {
        return Helpers\Helper::merge_array_sets($array1,$array2);
    }
}
//if (! function_exists('put')) {
//    function put($key,$data)
//    {
//        return Helpers\Helper::put($key,$data);
//    }
//}
//if (! function_exists('has')) {
//    function has($key)
//    {
//        return Helpers\Helper::has($key);
//    }
//}
//if (! function_exists('responseFormat')) {
//    function responseFormat($key,$data)
//    {
//        return Helpers\Helper::responseFormat($key,$data);
//    }
//}
//
