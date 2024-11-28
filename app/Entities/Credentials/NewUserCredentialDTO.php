<?php

namespace App\Entities\Credentials;

class NewUserCredentialDTO
{
    public string $email;
    public string $passwordHash;

    public function __construct(string $email, string $passwordHash) 
    {
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public static function fromArray(array $loginData) : self
    {
        return new self($loginData['email'], $loginData['passwordHash']);
    }

    public function toArray() : array
    {
        return ['email'=> $this->email, 'passwordHash'=> $this->passwordHash];
    }

    public function toModel() : UserCredentialModel
    {
        $userCredentialModel = new UserCredentialModel();

        $userCredentialModel->email = $this->email;
        $userCredentialModel->pass_hash = $this->passwordHash;

        return $userCredentialModel;
    }
}

