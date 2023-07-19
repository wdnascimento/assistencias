<?php

namespace App\Http\Requests\Admin\Professor;

use Illuminate\Foundation\Http\FormRequest;

class ProfessorUpdateRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:professors,email,'.$this->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'email.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'email.email' =>'O campo :attribute precisa ser um email válido!',

            'email.unique' =>':attribute já cadastrado',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
        ];
    }
}
