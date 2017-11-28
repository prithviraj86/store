<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public $timestamps = false;

    public function productCategory()
    {
        return $this->hasOne(ProductCategory::class);
    }

}
