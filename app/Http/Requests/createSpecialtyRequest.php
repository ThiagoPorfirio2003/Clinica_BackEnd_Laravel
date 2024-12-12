<?php

namespace App\Http\Requests;

use App\Entities\Credentials\UserCredentialModel;
use App\Entities\Users\UserRoles;
use App\Services\Specialty\SpecialtyService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class createSpecialtyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $credentialId = Auth::id();
        $isAuthorized = false;

        if($credentialId != null)
        {
            try
            {
                $credentialModel =  UserCredentialModel::where('id', $credentialId)->first();
        
                $isAuthorized = UserRoles::fromDataBase($credentialModel->userProfile->role) == UserRoles::ADMIN;
            }
            catch(\Exception $e)
            {
                 
            }
        }

        return $isAuthorized;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:5,100|regex:~^[A-Za-zÁÉÍÓÚáéíóú\s]+$~',
            'avgAppointmentMinutes' => 'required|integer|between:10,180'
            //
        ];
    }

    public function after() : array
    {
        return [
            function(Validator $validator)
            {
                if($validator->errors()->isEmpty())
                {
                    $specialtyService = new SpecialtyService();
                
                    try
                    {
                        if($specialtyService->nameExists($this->post('name')))
                        {
                            $validator->errors()->add('name', 'El nombre ya existe');
                        }
                    }
                    catch(\Exception $e)
                    {
                        abort(500, 'Hay un problema con los servidores');
                    }
                }
            }
        ];
    }
}
