<?php

namespace App\Discount;

interface DiscountStrategyInterface
{
    public function calculate(float $price): float;
}
