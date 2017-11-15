<?php
namespace App\Libraries;

use function Sodium\increment;
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

        $this->db->query()->insert(['product_id'=>$data['product_id'],'customer_id'=>$this->user_id,'quantity'=>increment()]);



    }
    public function remove(int $product_id)
    {
        $this->db->query()
                    ->where('product_id','=',$product_id)
                    ->where('customer_id','=',$this->user_id)
                    ->delete();



    }
    public function clear()
    {
        $this->db->query()
            ->where('customer_id','=',$this->user_id)
            ->delete();
    }
}