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
