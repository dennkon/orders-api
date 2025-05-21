<?php

namespace App\Services;

use App\DTO\OrderData;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $repository
    ) {}

    public function createOrder(OrderData $orderData): Order
    {
        return DB::transaction(function () use ($orderData) {
            $order = $this->repository->create([
                'customer_name' => $orderData->customer_name,
                'customer_email' => $orderData->customer_email,
                'total_price' => 0, // Will be updated after adding products
            ]);

            $totalPrice = 0;
            $orderProducts = [];

            foreach ($orderData->products as $productItem) {
                $product = Product::findOrFail($productItem['product_id']);
                $quantity = $productItem['quantity'];
                $price = $product->price * $quantity;
                $totalPrice += $price;

                $orderProducts[$product->id] = ['quantity' => $quantity];
            }

            // Attach products with quantities
            $order->products()->attach($orderProducts);

            // Update total price
            $order->update(['total_price' => $totalPrice]);

            return $order->load(['products']);
        });
    }

    public function getOrderById(int $id): Order
    {
        $order = $this->repository->findById($id);

        if (!$order) {
            throw new ModelNotFoundException("Order with id {$id} not found");
        }

        return $order->load(['products']);
    }
}
