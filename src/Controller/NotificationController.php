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
