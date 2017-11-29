<?php
namespace  App\Repositories\ProductCategory;

use Illuminate\Http\Request;

interface ProductCategoryInterface
{
    public function all();

    public function productByCategory(Request $request);

}