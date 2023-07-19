<?php

namespace App\Http\Requests\Aluno;

use App\Rules\Aluno\ValidarDesistirSenha;
use Illuminate\Foundation\Http\FormRequest;

class DesistirSenhaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'aula_id' => 'required',
            'aula_id' => new ValidarDesistirSenha,

        ];
    }

    public function messages()
    {
        return [
            'aula_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
        ];
    }

    public function attributes()
    {
        return [
            'aula_id' => 'Aula',
        ];
    }
}
