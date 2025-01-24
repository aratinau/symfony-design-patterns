<?php

namespace App\Discount;

/*
 * Maintenant, on va créer une classe qui utilisera ces stratégies.
 * Cette classe ne se préoccupe pas du type de réduction à appliquer,
 * elle délègue cette logique à la stratégie qu’on lui passe.
 */
class DiscountContext
{
    public function __construct(
        private DiscountStrategyInterface $discountStrategy
    ) {
    }

    public function applyDiscount(float $price):float
    {
        return $this->discountStrategy->calculate($price);
    }
}
