<?php

namespace App\Discount;

class PremiumDiscountStrategy implements DiscountStrategyInterface
{
    public function calculate(float $price): float
    {
        return $price * 0.9; // 10% de réduction
    }

}
