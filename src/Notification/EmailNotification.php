<?php

namespace App\Notification;

class EmailNotification implements NotificationInterface
{
    public function send(string $message): void
    {
        echo "Email envoyé : $message" ;
    }

}
