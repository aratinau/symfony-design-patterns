<?php

namespace App\Discount;

class VIPDiscountStrategy implements DiscountStrategyInterface
{
    public function calculate(float $price): float
    {
        return $price * 0.80; // 20% de réduction
    }

}
