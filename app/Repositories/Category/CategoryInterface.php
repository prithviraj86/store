<?php
namespace App\Repositories\Category;


interface CategoryInterface
{
    public function add(string $cat_name);
    public function all();
    public function find(int $id);
    public function update(int $id,string $name);
    public function remove(int $id);

}