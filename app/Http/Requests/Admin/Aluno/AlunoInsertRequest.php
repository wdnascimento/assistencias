<?php

namespace App\Http\Requests\Admin\Aluno;

use Illuminate\Foundation\Http\FormRequest;

class AlunoInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'numero' => 'required|unique:users,numero',
            'password' => 'required|size:8',
            'cabine' => 'required',
            'ano' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'numero.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'numero.unique' =>'O campo :attribute já está cadastrado',
            'cabine.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'password.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'password.size' =>'O campo :attribute deve ter :size caracteres respeitando o formato (DDMMAAAA)!',
            'ano.required' =>'O campo :attribute é de preenchimento obrigatório!',

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'numero' => 'Número',
            'password' => 'Senha',
            'cabine' => 'Cabine',
            'ano' => 'Ano',
        ];
    }
}
