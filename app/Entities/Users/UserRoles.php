<?php

namespace App\Entities\Users;

enum UserRoles : int
{
    case ADMIN = 0;
    case PATIENT = 1;
    case DOCTOR = 2;

    public function label() : string
    {
        return match($this)
        {
            self::ADMIN => 'ADMIN',
            self::PATIENT => 'PATIENT',
            self::DOCTOR => 'DOCTOR'
        };
    }

    public function asString() : string
    {
        return (string) $this->value;
    }

    public static function fromDataBase(string $dataBaseValue) : self
    {
        return match($dataBaseValue)
        {
            'ADMIN' => self::ADMIN, 
            'PACIENT' => self::PATIENT,
            'DOCTOR' => self::DOCTOR,
            default => throw new \InvalidArgumentException("Rol de usuario invalido: $dataBaseValue")
        };
    }

    public static function fromInt(int $value) : self
    {
        return match($value)
        {
            0 => self::ADMIN,
            1 => self::PATIENT,
            2 => self::DOCTOR
        };
    }
}