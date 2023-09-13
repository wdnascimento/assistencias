<?php

namespace App\Http\Requests\Aluno;

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
            'numero'                =>  ['required'],
            'password'              =>  ['required'],
            'g-recaptcha-response'  =>  ['required',new GoogleRecaptcha],
        ];
    }

    public function messages()
    {
        return [
            'numero.required' =>'O campo :attribute é obrigatório!',
            'password.required' =>'O campo :attribute é obrigatório!',
            'g-recaptcha-response.required' =>'O campo :attribute é obrigatório!',
        ];
    }

    public function attributes()
    {
        return [
            'numero'                => 'Numero',
            'password'              => 'Senha',
            'g-recaptcha-response'  => 'Google Recaptcha',
        ];
    }
}
