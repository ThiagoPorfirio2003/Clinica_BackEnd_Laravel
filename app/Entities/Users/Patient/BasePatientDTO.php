<?php

namespace App\Entities\Users\Patient;

readonly class BasePatientDTO
{
    public function __construct(public int $insuranceNumber) 
    {

    }

    /**
     * Undocumented function
     *
     * @param array<string,mixed> $data
     * @return self
     */
    public static function fromArray(array $data) : self
    {
        return new self($data['insuranceNumber']);
    }

    public function toModel(int $profileId) : PatientModel
    {
        $patientModel = new PatientModel();

        $patientModel->id = $profileId;
        $patientModel->insurance_number = $this->insuranceNumber;

        return $patientModel;
    }
}