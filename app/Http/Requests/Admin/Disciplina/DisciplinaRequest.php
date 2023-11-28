<?php

namespace App\Http\Requests\Admin\Disciplina;

use Illuminate\Foundation\Http\FormRequest;

class DisciplinaRequest extends FormRequest
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
            'titulo' => 'required|min:3|unique:disciplinas',
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
