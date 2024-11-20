<?php

namespace App\Entities\Users;

enum UserRoles : int
{
    case ADMIN = 0;
    case PACIENT = 1;
    case DOCTOR = 2;

    public function label() : string
    {
        return match($this)
        {
            self::ADMIN => 'ADMIN',
            self::PACIENT => 'PATIENT',
            self::DOCTOR => 'DOCTOR'
        };
    }

    public static function fromDataBase(string $dataBaseValue) : self
    {
        return match($dataBaseValue)
        {
            'ADMIN' => self::ADMIN, 
            'PACIENT' => self::PACIENT,
            'DOCTOR' => self::DOCTOR,
            default => throw new \InvalidArgumentException("Rol de usuario invalido: $dataBaseValue")
        };
    }

    public static function fromInt(int $value) : self
    {
        return match($value)
        {
            0 => self::ADMIN,
            1 => self::PACIENT,
            2 => self::DOCTOR
        };
    }
}