<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Hash;

class UserPassword implements Rule
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
     * Validate if typed password matches the one inside the DB
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (Hash::check($value['request'], $value['db'])) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
         return 'Usuário ou senha não conferem.';
    }
}
