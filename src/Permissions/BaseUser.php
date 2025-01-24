<?php

namespace App\Permissions;

class BaseUser implements PermissionInterface
{
    public function checkAccess(): bool
    {
        return false;
    }

}
