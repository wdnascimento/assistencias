<?php

namespace App\Http\Requests\Admin\Disciplina;

use Illuminate\Foundation\Http\FormRequest;

class DisciplinaUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|min:3|unique:disciplinas,titulo,'.$this->id,
            'grupo_disciplina_id' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'titulo.required' =>'O campo título é de preenchimento obrigatório!',
            'titulo.min' =>'O campo título precisa ter no mínimo 3 caracteres!',
            'titulo.unique' =>'Disciplina já cadastrada',
            'grupo_disciplina_id.required' =>'O grupo de disciplinas é obrigatório!',
        ];
    }


}
