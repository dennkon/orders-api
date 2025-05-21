<?php

namespace App\DTO;

class OrderDTO
{
    /**
     * @param string $customer_name
     * @param string $customer_email
     * @param OrderItemDTO[] $items
     */
    public function __construct(
        public string $customer_name,
        public string $customer_email,
        public array $items
    ) {}
}
