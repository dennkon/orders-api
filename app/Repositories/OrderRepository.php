<?php

namespace App\Repositories;

use App\Models\Order;

/**
 *
 */
class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }
    public function findById(int $id): ?Order
    {
        return Order::with('products')->find($id);
    }
}

