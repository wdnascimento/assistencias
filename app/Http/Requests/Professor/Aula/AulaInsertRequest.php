<?php

namespace App\Http\Requests\Professor\Aula;

use App\Rules\Admin\ValidarAulaProfessor;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Professor\ValidarAula;

class AulaInsertRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    // {{-- disciplina_id, sala_id, professor_id --}}

    public function rules()
    {
        $values = $this->request;

        return [
                'disciplina_id' => 'required',
                'sala_id' => 'required' ,
                'professor_id' => 'required' ,
        ];
    }

    public function messages()
    {
        return [
            'disciplina_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'sala_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'professor_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
        ];
    }

    public function attributes()
    {
        return [
            'disciplina_id' => 'Disciplina',
            'sala_id' => 'Sala' ,
            'professor_id' => 'Professor',
        ];
    }





}
