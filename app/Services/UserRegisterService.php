<?php

namespace App\Services\User;

class UserRegisterService
{
    public function __construct(
        //private UserCredentialService $userCredentialService,
        //private UserProfile $userProfileService,
        //private PatientService $patientService
        ) 
    {}


    /*
    No se si mas adelante me servira

    public function userExists(string $email, int $dni) : bool
    {
        return UserCredential::where('email', $email)->exists() || UserProfile::where('dni', $dni);
    }

    public function userDataExists(string $email, string $emailFoundMessage,  int $dni, string $dniFoundMessage) : array
    {
        $dataEncontrada = [];
        
        if(UserCredential::where('email', $email)->exists())
        {
            $dataEncontrada[] = $emailFoundMessage;
        }

        if(UserProfile::where('dni', $dni)->exists())
        {
            $dataEncontrada[] = $dniFoundMessage;
        }

        return $dataEncontrada;
    }

    public function patientDataExists(int $insuranceNumber, string $insuranceFoundMessage) : array 
    {
        $dataEncontrada = [];
        
        if(Patient::where('insurance_number', $insuranceNumber)->exists())
        {
            $dataEncontrada[] = $insuranceFoundMessage;
        }

        return $dataEncontrada;
    }

    private function registerPatient(PatientRegisterRequestDTO $patientData) : void
    {
        try
        {
            $dataExistingMessages = $this->userDataExists($patientData->email, 'El email ya pertenece a otro usuario',
            $patientData->dni, 'El DNI ya pertenece a otro usuario');

            $dataExistingMessages = array_merge($dataExistingMessages, $this->patientDataExists($patientData->insuranceNumber, 
            'El numero de obra social ya pertence a otro usuario'));
            
            if(count($dataExistingMessages))
            {

            }
        }
        catch(\Exception)
        {

        }
    }
    */
}