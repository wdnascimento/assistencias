<?php

namespace App\Http\Requests\Admin\GrupoDisciplina;

use Illuminate\Foundation\Http\FormRequest;

class GrupoDisciplinaRequest extends FormRequest
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
            'titulo' => 'required|min:3|unique:grupo_disciplinas'
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
