<?php

namespace App\Http\Requests\Admin\Administrador;

use Illuminate\Foundation\Http\FormRequest;

class AdministradorInsertRequest extends FormRequest
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
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'email.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'email.email' =>'O campo :attribute precisa ser um email válido!',

            'email.unique' =>':attribute já cadastrada',
            'password.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'password.confirmed' =>'O campo :attribute precisa ser confirmado',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha',
        ];
    }
}
