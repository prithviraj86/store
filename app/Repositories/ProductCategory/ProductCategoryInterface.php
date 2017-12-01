<?php
namespace  App\Repositories\ProductCategory;

use App\Models\Product;
use Illuminate\Http\Request;

interface ProductCategoryInterface
{
    public function add(Product $product,array $category);
    public function all();

    public function productByCategory(Request $request);

}