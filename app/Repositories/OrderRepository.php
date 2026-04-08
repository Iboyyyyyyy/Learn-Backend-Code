<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetails;

class OrderRepository
{
    public function createOrder($data)
    {
        return Order::create($data);
    }

    public function insertDetails($deails)
    {
        return OrderDetails::insert($deails);
    }

    public function updateOrder($id, $data)
    {
        return Order::where('order_id', $id)->update($data);
    }
}





//             insert data to database
