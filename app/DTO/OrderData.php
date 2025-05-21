<?php

namespace App\DTO;

class OrderData
{
    public function __construct(
        public readonly string $customer_name,
        public readonly string $customer_email,
        public readonly array $products // массив ['product_id' => int, 'quantity' => int]
    ) {}

    public static function fromRequest(\App\Http\Requests\StoreOrderRequest $request): self
    {
        return new self(
            $request->input('customer_name'),
            $request->input('customer_email'),
            $request->input('products')
        );
    }
}
