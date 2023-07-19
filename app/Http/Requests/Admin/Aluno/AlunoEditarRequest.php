<?php

namespace App\Http\Requests\Admin\Aluno;

use Illuminate\Foundation\Http\FormRequest;

class AlunoEditarRequest extends FormRequest
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
            'numero' => 'required|unique:users,numero,'.$this->id,
            'password_aluno' => 'size:8',
            'cabine' => 'required',
            'ano' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'numero.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'numero.unique' =>':attribute já cadastrado',
            'cabine.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'password_aluno.size' =>'O campo :attribute deve ter :size caracteres respeitando o formato (DDMMAAAA)!',
            'ano.required' =>'O campo :attribute é de preenchimento obrigatório!',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'numero' => 'Número',
            'cabine' => 'Cabine',
            'ano' => 'Ano',
            'password_aluno' => 'Senha',
        ];
    }
}
