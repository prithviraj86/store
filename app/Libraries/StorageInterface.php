<?php
namespace App\Libraries;

/**StorageInterface used to store values in cart it is used in any type storage format
 * StorageInterface  is used in SessionStorage and Dbstorage
 */
interface StorageInterface
{

    public function add(array $data);

    public function remove(int $product_id);

    public function getAll();

    public function clear();

    public function decreseQuantity(int $product_id);


}