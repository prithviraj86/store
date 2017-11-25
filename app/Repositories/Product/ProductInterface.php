<?php
namespace App\Repositories\Product;

interface ProductInterface
{

    public function add(array $data);
    public function all();
    public function find(int $id);
    public function update(int $id,array$data);
    public function remove(int $id);

}