<?php
namespace App\Helpers;

class Helper
{

    public function setOrblank($value)
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
    public function setOrNotBlank($value)
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
    public function invalidString()
    {

    }

}
?>