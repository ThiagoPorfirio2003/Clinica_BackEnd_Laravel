<?php

namespace App\Entities\Users\Profile;

use App\Entities\Users\UserRoles;

abstract class BaseUserProfileDTO 
{
    protected function __construct(
        public string $name,
        public string $surname,
        public string $birthdate,
        public int $dni,
        public bool $isEnabled,
        public UserRoles $role)
    {}
}