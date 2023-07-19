<?php

namespace App\Rules\Admin\Arquivo;

use Illuminate\Contracts\Validation\Rule;

class ValidarArquivoCvs implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->error = '';
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
        if(strtolower($value->getClientOriginalExtension()) != 'csv'){
            $this->error='O arquivo precisa respeitar o formato de CSV';
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  $this->error;
    }


}
