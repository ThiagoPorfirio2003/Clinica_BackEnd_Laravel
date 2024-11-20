<?php

/*
namespace App\Entities\Users\Profile;

use App\Enums\UserRoles;

class NewUserProfileDTO extends BaseUserProfileDTO
{
    public function __construct(
        string $name,
        string $surname,
        string $birthdate,
        int $dni,
        bool $isEnabled,
        UserRoles $role,
        public int $credentialId,
        public string $imgPath)
    {
        parent::__construct($name, $surname, $birthdate, $dni, $isEnabled, $role);
    }

    /**
     * Undocumented function
     *
     * @param array<string, mixed> $data
     * @return self
     /
    public function fromArray(array $data) : self
    {
        return new self(
            $data['name'],
            $data['surname'],
            $data['birthdate'],
            $data['dni'],
            $data['isEnabled'],
            $data['role'],
            $data['credentialId'],
            $data['imgPath']
        );
    }
    
}
*/