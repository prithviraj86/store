<?php
namespace App\Libraries;

use App\Models\Product;
/**StorageInterface used to store values in cart it is used in any type storage format
 * StorageInterface  is used in SessionStorage and Dbstorage
 */
interface StorageInterface
{

    public function add(Product $product,int $quantity=0);

    public function remove(Product $product);

    public function getAll();

    public function clear();

    public function decreseQuantity(Product $product);


}