<?php
namespace App\Libraries;

use App\Models\Product;
use Illuminate\Http\Request;

class FileStorage
{
    public static function uploadProduct(Product $product,Request $request)
    {
        $filename=(string)$product->id.".".$request->file('photo')->extension();
        $request->file('photo')->storeAs('proimages',$filename,'public');
    }
}