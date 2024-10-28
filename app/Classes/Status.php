<?php

namespace App\Classes;

class MyStatus
{
    private bool $success;
    private string $message;

    public function __construct(bool $success, string $message) 
    {
        $this->success = $success;
        $this->message = $message;
    }

    public function getSuccess() : bool
    {
        return $this->success;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function setSuccess(bool $success) : void
    {
        $this->success = $success;
    }

    public function setMessage($message) : void
    {
        $this->message = $message;
    }
}