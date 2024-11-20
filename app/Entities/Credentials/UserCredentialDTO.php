<?php

namespace App\Entities\Credentials;

use Illuminate\Support\Carbon;

class UserCredetinalDTO extends newUserCredentialDTO
{
    private function __construct(string $email, string $password,
        public int $id,
        public string | null $rememberToken,
        public Carbon | null $emailVerifiedAt,
        public Carbon | null $createdAt,
        public Carbon | null $updatedAt
        ) 
    {
        parent::__construct($email, $password);

        $this->id;
        $this->rememberToken;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function fromArray(array $userCredential) : self
    {
        return new self($userCredential['email'], $userCredential['password'],
        $userCredential['id'], $userCredential['remember_token'],
        $userCredential['email_verified_at'], $userCredential['created_at'],
        $userCredential['updated_at']);
    }
}