<?php

namespace App\Rules;

use App\Services\Credentials\UserCredentialService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class uniqueEmailRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $userCredentialsService = new UserCredentialService();
        $uniqueEmail = false;

        try
        {
            $uniqueEmail = $userCredentialsService->emailExists($value);
        }
        catch(\Exception)
        {

        }

        if($userCredentialsService->emailExists($value))
        {
            $fail('El :' . $attribute . ' ya pertenece a otro usuario');
        }
        else
        {
            $fail('El :' . $attribute . ' vale: ' . $value);
        }
    }
}
