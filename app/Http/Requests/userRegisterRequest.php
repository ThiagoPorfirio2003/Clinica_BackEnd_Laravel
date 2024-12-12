<?php

namespace App\Http\Requests;

use App\Entities\Credentials\UserCredentialModel;
use App\Entities\Users\UserRoles;
use App\Services\Credentials\UserCredentialService;
use App\Services\User\UserProfileService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
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
        /*
            Si el usuario no esta registrado o es de tipo admin.
            Quizas puedo usar el MW para lo 1ro
        */
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

        //Deberia agregar que isEnabled pueda existir solo si el usuario que hace la request es admin
        return [
            'email' => 'required|between:10,50|email:strict,spoof,dns',
            'password' => 'required|string|between:10,100|regex:~^[^\s\n\r\t\'\"\\\/]+$~', //Caracteres no permitidos: '', "", \s, \n, \r, \t, \ y /
            'name' => 'required|string|between:2,40|regex:~^[A-Za-zÁÉÍÓÚáéíóú\s]+$~', //1 o 2 nombres
            'surname' => 'required|string|between:2,20|regex:~^[A-Za-zÁÉÍÓÚáéíóú]+$~', //1 apellido
            'birthdate' => 'required|date|before_or_equal:' . $today->toDateString(),
            'dni' => 'required|integer|between:10000000,80000000', //El valor maximo deberia ser actualizado mas adelante,
            'role' => ['required', Rule::enum(UserRoles::class)],
            'img' => 'required|file|max:'. 1024 * 2 .'|extensions:jpg,png,jpeg|mimes:jpg,png,jpeg',
            //'insuranceNumber' => 'required_if:role,' . UserRoles::PATIENT->asString() . '|integer|'
        ];
    }

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
                        $hasPermission = false;
                        $hasErrors = true;
                        $fromAdmin = false;

                        $isEnabledExists = array_key_exists('isEnabled', $this->post());
                        $credentialId = Auth::id();

                        if($credentialId != null)
                        {
                            $credentialModel =  UserCredentialModel::where('id', $credentialId)->first();

                            $fromAdmin = UserRoles::fromDataBase($credentialModel->userProfile->role) == UserRoles::ADMIN;
                        }

                        if($fromAdmin)
                        {
                            $hasPermission = true;
                            if($isEnabledExists)
                            {
                                $isEnabled = $this->post('isEnabled');
                                $isEnabled = is_string($isEnabled) ? strtolower($isEnabled) : $isEnabled;

                                if(is_bool($isEnabled) || in_array($isEnabled, ['true', 'false', 0, 1, '0', '1'], true))
                                {
                                    $hasErrors = false;
                                }
                                else
                                {
                                    $validator->errors()->add('isEnabled', 'El campo debe ser de tipo boolean');
                                }
                            }
                            else
                            {
                                $validator->errors()->add('isEnabled', 'El campo debe existir');
                                $validator->errors()->add('isEnabled', 'El campo debe ser de tipo boolean');
                            }
                        }
                        else
                        {
                            if(UserRoles::fromInt($this->post('role')) == UserRoles::PATIENT)
                            {
                                $hasPermission = true;

                                if($isEnabledExists)
                                {
                                    $validator->errors()->add('isEnabled', 'El campo no debe existir');
                                }
                                else
                                {
                                    $hasErrors = false;
                                }
                            }
                        }

                        if($hasPermission)
                        {
                            if(!$hasErrors)
                            {
                                if($userCredentialService->emailExists($this->post('email')))
                                {
                                    $validator->errors()->add('email', 'El EMAIL pertenece a otro usuario');
                                }
            
                                if($userProfileService->dniExists($this->post('dni')))
                                {
                                    $validator->errors()->add('dni', 'El DNI pertenece a otro usuario');
                                }
                            }
                        }
                        else
                        {
                            $validator->errors()->add('Autenticacion', 'No estás autorizado para realizar esta acción');
                        }
                    }
                    catch(\Exception)
                    {
                        abort(500, 'Hay un problema con los servidores');
                    }
                }
            }
        ];
    }
}
