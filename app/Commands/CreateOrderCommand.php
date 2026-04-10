<?php

namespace App\Commands;

class CreateOrderCommand
{
    public function __construct(
        public int $customerId,
        public array $orderItems
    ) {}
}
