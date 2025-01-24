# Symfony Design Patterns

`make build`

`make up`

## Pattern Strategy

https://dev.to/technivek/simplifier-la-gestion-des-comportements-avec-le-pattern-strategy-en-php-et-symfony-51km

https://localhost/strategy

```json
{
    "Prix final après réduction": 90
}
```

### Interface de la stratégie

```php
<?php

namespace App\Discount;

interface DiscountStrategyInterface
{
    public function calculate(float $price): float;
}
```

### Stratégies spécifiques

```php
<?php

namespace App\Discount;

class NoDiscountStrategy implements DiscountStrategyInterface
{
    public function calculate(float $price): float
    {
        return $price;
    }

}

<?php

namespace App\Discount;

class PremiumDiscountStrategy implements DiscountStrategyInterface
{
    public function calculate(float $price): float
    {
        return $price * 0.90; // 10% de réduction
    }

}

<?php

namespace App\Discount;

class VIPDiscountStrategy implements DiscountStrategyInterface
{
    public function calculate(float $price): float
    {
        return $price * 0.80; // 20% de réduction
    }

}
```

### Classe de contexte

```php
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
```

### Utilisation dans un controller

```php
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

```
