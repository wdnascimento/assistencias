<?php

namespace App\Http\Requests\Admin\GrupoDisciplina;

use Illuminate\Foundation\Http\FormRequest;

class GrupoDisciplinaUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|min:3|unique:grupo_disciplinas,titulo,'.$this->id
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' =>'O campo título é de preenchimento obrigatório!',
            'titulo.min' =>'O campo título precisa ter no mínimo 3 caracteres!',
            'titulo.unique' =>'Grupo de Disciplina já cadastrada',
        ];
    }


}
