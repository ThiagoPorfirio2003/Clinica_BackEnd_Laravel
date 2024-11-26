<?php

namespace App\Http\Requests;

use App\Entities\Users\UserRoles;
use App\Rules\uniqueEmailRule;
use App\Services\Credentials\UserCredentialService;
use App\Services\User\UserProfileService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class userRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $today = Date::today();

        $today->subMonths(216);//18 anios

        //No se valida que no haya espacios al inicio y final porque ya hay un MW
        //dentro del web group que hace eso
        return [
            'email' => 'required|between:10,50|email:strict,spoof,dns',
            'password' => 'required|string|between:10,100|regex:~^[^\s\n\r\t\'\"\\\/]+$~', //Caracteres no permitidos: '', "", \s, \n, \r, \t, \ y /
            'name' => 'required|string|between:2,40|regex:~^[A-Za-zÁÉÍÓÚáéíóú\s]+$~', //1 o 2 nombres
            'surname' => 'required|string|between:2,20|regex:~^[A-Za-zÁÉÍÓÚáéíóú]+$~', //1 apellido
            'birthdate' => 'required|date|before_or_equal:' . $today->toDateString(),
            'dni' => 'required|integer|between:10000000,80000000', //El valor maximo deberia ser actualizado mas adelante,
            'isEnabled' => 'missing',
            'role' => ['required', Rule::enum(UserRoles::class)],
            'img' => 'required|file|max:'. 1024 * 2 .'|extensions:jpg|mimes:jpg'
        ];
        //Despues de todas las validacions tengo que agregar otra que consulte a la base de datos si 
        //existe o no el email, el dni y si hay insurance_number, que lo valide
    }

    /*
            email
        password

        name
        surname
        birthdate
        dni
        isEnabled (Si no viene, por defecto es true)
        role
        profileImg tipo UploadedFile

        Informacion segun el tipo de usuario, puede ser el
        insuranceNumber
    */


    public function after(): array
    {
        return [
            function (Validator $validator) {
                if($validator->errors()->isEmpty())
                {
                    $userCredentialService = new UserCredentialService();
                    $userProfileService = new UserProfileService();
                    
                    try
                    {
                        if($userCredentialService->emailExists($this->input('email')))
                        {
                            $validator->errors()->add('email', 'El EMAIL pertenece a otro usuario');
                        }
    
                        if($userProfileService->dniExists($this->input('dni')))
                        {
                            $validator->errors()->add('dni', 'El DNI pertenece a otro usuario');
                        }
                    }
                    catch(\Exception)
                    {
                        $validator->errors()->add('email', 'Error en el servidor');
                        $validator->errors()->add('dni', 'Error en el servidor');
                    }
                }
            }
        ];
    }
}
