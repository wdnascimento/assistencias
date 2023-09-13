<?php

namespace App\Http\Requests\Admin\Unidade;

use Illuminate\Foundation\Http\FormRequest;


class UnidadeRequest extends FormRequest
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
            'titulo' => 'required|unique:unidades,titulo,'.$this->id,
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' =>'O campo título é de preenchimento obrigatório!',
            'titulo.unique' =>'Unidade já cadastrada',
        ];
    }
}
