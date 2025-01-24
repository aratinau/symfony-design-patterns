<?php

namespace App\Permissions;

interface PermissionInterface
{
    public function checkAccess(): bool;
}
