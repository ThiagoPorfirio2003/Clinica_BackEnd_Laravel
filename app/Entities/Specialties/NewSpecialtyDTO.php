<?php

namespace App\Entities\Specialties;

readonly class NewSpecialtyDTO
{
    public function __construct(
        public string $name,
        public int $avgAppointmentMinutes
        ) 
    {}

    public static function fromArray(array $data) : self
    {
        return new self(
            $data['name'],
            $data['avgAppointmentMinutes']
        );
    }

    public function toModel() : SpecialtyModel
    {
        $newModel = new SpecialtyModel();

        $newModel->name = $this->name;
        $newModel->avg_appointment_minutes = $this->avgAppointmentMinutes;

        return $newModel;
    }
}