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
            'numero' => 'required|size:8|unique:users,numero,'.$this->id,
            'password_aluno' => 'size:8',
            'turma_id' => 'required',

            'ano' => 'required',
            'celular' => 'required_if:send_sms,1|size:15',
            'cabine' => 'required_if:send_sms,0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'numero.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'numero.unique' =>':attribute já cadastrado',
            'numero.size' =>'O campo :attribute deve ter :size caracteres respeitando o formato 00000000!',

            'ano.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'turma_id.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'celular.required_if' =>'O campo :attribute é de preenchimento obrigatório!',
            'celular.size' =>'O campo :attribute deve observar o formato (00) 00000-0000!',
            'cabine.required_if' =>'O campo :attribute é de preenchimento obrigatório!',

            'password_aluno.size' =>'O campo :attribute deve ter :size caracteres respeitando o formato (DDMMAAAA)!',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'numero' => 'Número',
            'password_aluno' => 'Senha',

            'cabine' => 'Cabine',
            'celular' => 'Celular',
            'turma_id' => 'Turma',

            'ano' => 'Ano',
        ];
    }
}
