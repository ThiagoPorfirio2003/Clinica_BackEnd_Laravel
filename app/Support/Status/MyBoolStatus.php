<?php

namespace App\Classes\Status;

class MyBoolStatus
{
    public function __construct(
        public bool $result, 
        public string $message) 
    {}

    public function changeToFail(string $failMessage) : void
    {
        $this->message = $failMessage;
        $this->result = false;
    }

    public function changeToSuccess(string $successMessage) : void
    {
        $this->message = $successMessage;
        $this->result = true;
    }

    public static function createFail(string $failMessage = 'La operación fallo') : self
    {
        return new self(false, $failMessage);
    }

    public static function createSuccess(string $successMessage = 'La operación fue exitosa') : self
    {
        return new self(true, $successMessage);
    }
}