<?php
use App\Helpers;

if (! function_exists('setOrBlank')) {
    function setOrblank($value)
    {
        return Helpers\Helper::setOrBlank($value);
    }
}
if (! function_exists('setOrNotBlank')) {
    function setOrNotBlank($value)
    {
        return Helpers\Helper::setOrNotBlank($value);
    }
}
if (! function_exists('responseFormat')) {
    function responseFormat($key,$data)
    {
        return Helpers\Helper::responseFormat($key,$data);
    }
}

?>