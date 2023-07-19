<?php

namespace App\Http\Requests\Api\Aluno;

use App\Rules\Aluno\ValidarDesistirSenha;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DesistirSenhaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'aula_id' => 'required|integer',
            'aula_id.unique' => new ValidarDesistirSenha,

        ];
    }

    public function messages()
    {
        return [
            'aula_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'aula_id.integer' =>'O campo :attribute deve ser um número!',
        ];
    }

    public function attributes()
    {
        return [
            'aula_id' => 'Aula',
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Erro de Validação',
            'data'      => $validator->errors()
        ]));

    }
}
