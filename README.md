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

## Pattern Factory

https://notification

### Interface de la stratégie

```php
<?php

namespace App\Notification;

interface NotificationInterface
{
    public function send(string $message): void;
}
```

### Implémentations spécifiques

```php
<?php

namespace App\Notification;

class EmailNotification implements NotificationInterface
{
    public function send(string $message): void
    {
        echo "Email envoyé : $message" ;
    }

}

<?php

namespace App\Notification;

class PushNotification implements NotificationInterface
{
    public function send(string $message): void
    {
        echo "Push envoyé : $message" ;
    }

}

<?php

namespace App\Notification;

class SMSNotification implements NotificationInterface
{
    public function send(string $message): void
    {
        echo "SMS envoyé : $message" ;
    }

}

```

### La factory

```php
<?php

namespace App\Notification;

class NotificationFactory
{
    public static function create(string $type): NotificationInterface
    {
        return match ($type) {
            'email' => new EmailNotification(),
            'sms' => new PushNotification(),
            'push' => new PushNotification(),
            default => throw new \Exception('Invalid notification type'),
        };
    }
}

```

### Utilisation dans un controller

```php
<?php

namespace App\Controller;

use App\Notification\NotificationFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index(): Response
    {
        $notificationType = 'email'; // ou 'sms', 'push'

        $notification = NotificationFactory::create($notificationType);
        $notification->send("Hello, voici un message de notification");

        echo '<br />';

        return new Response("Notification envoyée avec succès");
    }
}
```

## Pattern Decorator

### Interface de la stratégie

```php
<?php

namespace App\Permissions;

interface PermissionInterface
{
    public function checkAccess(): bool;
}
```

```php
<?php

namespace App\Permissions;

class BaseUser implements PermissionInterface
{
    public function checkAccess(): bool
    {
        return false;
    }

}

<?php

namespace App\Permissions;

class AdminPermissionDecorator implements PermissionInterface
{
    public function __construct(
        private PermissionInterface $permission
    ){
    }

    public function checkAccess(): bool
    {
        return true;
    }
}

<?php

namespace App\Permissions;

class ReadOnlyPermissionDecorator implements PermissionInterface
{
    public function __construct(
        protected PermissionInterface $user
    ){}

    public function checkAccess(): bool
    {
        return $this->user->checkAccess() || $this->canEditContent();
    }

    private function canEditContent()
    {
        return true;
    }
}

```

### Utilisation dans un controller

```php
<?php

namespace App\Controller;

use App\Permissions\AdminPermissionDecorator;
use App\Permissions\BaseUser;
use App\Permissions\EditorPermissionDecorator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DecoratorController extends AbstractController
{
    #[Route('/decorator', name: 'app_decorator')]
    public function index(): Response
    {
        $decorateUser = new BaseUser();
        $role = 'ROLE_ADMIN';

        if ($role === 'ROLE_ADMIN') {
            $decorateUser = new AdminPermissionDecorator($decorateUser);
        }

        if ($role === 'ROLE_EDITOR') {
            $decorateUser = new EditorPermissionDecorator($decorateUser);
        }

        if ($decorateUser->checkAccess()) {
            return new Response("Accès à la page d'édition accordé");
        }

        return new Response("Accès refusé");
    }
}

```
