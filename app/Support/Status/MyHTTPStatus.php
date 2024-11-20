<?php

namespace App\Support\Status;

class MyHTTPStatus
{
    public function __construct(public int $status = 418, 
    public string $message = 'Soy una taza de te') 
    {}

    public function changeStatus(int $status, string $message) : void
    {
        $this->status = $status;
        $this->message = $message;
    }

    public function changeStatusToOK(string $message = 'Operación realizada con éxito') : void
    {
        $this->changeStatus(200, $message);
    }

    public function changeStatusToCreated(string $message = 'Información guardada con éxito') : void
    {
        $this->changeStatus(201, $message);
    }

    public function changeStatusToConflict(string $message = 'La información recibida es inválida') : void
    {
        $this->changeStatus(409, $message);
    }

    public function changeStatusToServerError(string $message = 'Hay un problema con los servidores') : void
    {
        $this->changeStatus(500, $message);
    }

    public static function createStatusServerError(string $message = 'Hay un problema con los servidores') : self
    {
        return new self(500, $message);
    }

    public static function createOK(string $message = 'Operación realizada con éxito') : self
    {
        return new self(200, $message);
    }
}