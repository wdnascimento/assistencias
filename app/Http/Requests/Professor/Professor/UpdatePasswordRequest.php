<?php

namespace App\Http\Requests\Professor\Professor;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'password.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'password.confirmed' =>'O campo :attribute precisa ser confirmado',
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'Senha',
        ];
    }

}
