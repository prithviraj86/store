<?php
namespace App\Libraries;


use StorageInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\DatabaseManager;


class DBStorage implements StorageInterface
{
    private $db;
    private $user_id;
    public function __construct(DatabaseManager $db)
    {
        $this->db=$db;
    }

    public function add(array $data)
    {

        $this->db->table('carts')->updateOrInsert(['product_id'=>$data['product_id'],'customer_id'=>$this->user_id],['product_id'=>$data['product_id'],'customer_id'=>$this->user_id,'quantity'=>$data['quantity']]);



    }
    public function decreseQuantity(int $product_id)
    {
        $this->db->table('carts')->where(['product_id'=>$product_id,'customer_id'=>$this->user_id])->decrement('quantity');
    }

    public function remove(int $product_id)
    {
        $this->db->table('carts')
                    ->where('product_id','=',$product_id)
                    ->where('customer_id','=',$this->user_id)
                    ->delete();



    }
    public function clear()
    {
        $this->db->table('carts')
            ->where('customer_id','=',$this->user_id)
            ->delete();
    }
    public function getAll()
    {
        $this->db->table('carts')->get();
    }
}