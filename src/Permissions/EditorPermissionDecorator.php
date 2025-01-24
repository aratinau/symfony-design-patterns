<?php

namespace App\Permissions;

class EditorPermissionDecorator implements PermissionInterface
{
    public function __construct(
        private PermissionInterface $user
    ){
    }

    public function checkAccess(): bool
    {
        return $this->user->checkAccess() || $this->canEditContent();
    }

    private function canEditContent()
    {
        return true;
    }
}
