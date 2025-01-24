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
