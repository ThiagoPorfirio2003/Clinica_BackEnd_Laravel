<?php

namespace App\Classes;

class UserAccessData
{
    private string $email;
    private string $password;

    public function __construct(string $email, string $password) 
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function setEmail(string $newEmail)
    {
        $this->email = $newEmail;
    }

    public function setPassword(string $newPassword)
    {
        $this->password = $newPassword;
    }
}