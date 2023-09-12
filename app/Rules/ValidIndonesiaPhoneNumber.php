<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidIndonesiaPhoneNumber implements Rule
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
        // Basic regex pattern for Indonesian phone numbers
        return preg_match('/^(08[123456789]\d{7,10}|0[1-9]\d{6,9})$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nomor telpon anda tidak valid';
    }
}
