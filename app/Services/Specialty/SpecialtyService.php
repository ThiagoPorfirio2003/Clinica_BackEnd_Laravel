<?php

namespace App\Services\Specialty;

use App\Entities\Specialties\SpecialtyModel;

class SpecialtyService
{
    public function nameExists(string $name) : bool 
    {
       return SpecialtyModel::where('name', $name)->exists();
    }
}