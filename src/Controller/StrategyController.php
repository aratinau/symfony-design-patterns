<?php

namespace App\Controller;

use App\Discount\DiscountContext;
use App\Discount\PremiumDiscountStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class StrategyController extends AbstractController
{
    #[Route('/strategy', name: 'app_strategy')]
    public function index(): JsonResponse
    {
        $clientType = 'vip'; // standard, premium ou vip
        $price = 100;

        $strategy = match ($clientType) {
            'premium' => new PremiumDiscountStrategy(),
            'vip' => new PremiumDiscountStrategy(),
            default => new PremiumDiscountStrategy(),
        };

        $discountContext = new DiscountContext($strategy);
        $finalPrice = $discountContext->applyDiscount($price);

        return new JsonResponse(['Prix final après réduction' => $finalPrice]);
    }
}
