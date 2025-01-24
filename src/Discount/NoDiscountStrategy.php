<?php

namespace App\Discount;

class NoDiscountStrategy implements DiscountStrategyInterface
{
    public function calculate(float $price): float
    {
        return $price;
    }

}
