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
