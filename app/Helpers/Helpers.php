<?php
use App\Helpers;

if (! function_exists('gets')) {
    function gets($key)
    {
        return Helpers\Helper::gets($key);
    }
}
if (! function_exists('remove')) {
    function remove($key)
    {
        return Helpers\Helper::remove($key);
    }
}
if (! function_exists('put')) {
    function put($key,$data)
    {
        return Helpers\Helper::put($key,$data);
    }
}
if (! function_exists('has')) {
    function has($key)
    {
        return Helpers\Helper::has($key);
    }
}
if (! function_exists('responseFormat')) {
    function responseFormat($key,$data)
    {
        return Helpers\Helper::responseFormat($key,$data);
    }
}


?>