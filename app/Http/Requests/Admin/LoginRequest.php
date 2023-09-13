<?php

namespace App\Http\Requests\Admin;

use App\Rules\GoogleRecaptcha;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'                 =>  ['required','email'],
            'password'              =>  ['required'],
            'g-recaptcha-response'  =>  ['required',new GoogleRecaptcha],
        ];
    }

    public function messages()
    {
        return [
            'email.required' =>'O campo :attribute é obrigatório!',
            'email.email' =>'O campo :attribute precisa ser um e-mail!',
            'password.required' =>'O campo :attribute é obrigatório!',
            'g-recaptcha-response.required' =>'O campo :attribute é obrigatório!',
        ];
    }

    public function attributes()
    {
        return [
            'email'                => 'Numero',
            'password'              => 'Senha',
            'g-recaptcha-response'  => 'Google Recaptcha',
        ];
    }
}
