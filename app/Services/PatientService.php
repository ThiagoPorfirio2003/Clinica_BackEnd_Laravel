<?php

namespace App\Services\User;

use App\Entities\Users\Patient\PatientModel;

class PatientService
{
    /*
    No se si sera de utilidad
    public function exists(int $insuranceNumber): bool
    {
        try 
        {
            $exists = PatientModel::where('insurance_number', $insuranceNumber)->exists();
        } 
        catch (\PDOException $e) 
        {
            throw new \PDOException('Error en la base de datos');
        }

        return $exists;
    }

    public function create(int $insuranceNumber): PatientModel
    {
        $userCredentials = new PatientModel();

        $userCredentials->email = $insuranceNumber;

        return $userCredentials;
    }
    */
}