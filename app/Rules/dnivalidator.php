<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class dnivalidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->isValidNif($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Si seleccionas España debes introducir un DNI correcto (letra mayuscula incluida)';
    }

    public function isValidNif($nif)
    {
        $nifRegEx = '/^[0-9]{8}[A-Za-z]$/';
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";

        if (preg_match_all($nifRegEx, $nif)) {
            return ($letras[(substr($nif, 0, 8) % 23)] == $nif[8]);
        }

        return false;
    }
}
