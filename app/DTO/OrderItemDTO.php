<?php

namespace App\DTO;

class OrderItemDTO
{
    public function __construct(
        public int $product_id,
        public int $quantity
    ) {}
}
