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
