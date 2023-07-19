<?php

namespace App\Http\Requests\Admin\Aula;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Admin\ValidarAula;
use App\Rules\Admin\ValidarAulaProfessor;

class AulaInsertRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    // {{-- id, disciplina_id, teacher_id, sala_id, titulo, inicio, fim, status, created_by, created_at, updated_at --}}

    public function rules()
    {
        return [
                'disciplina_id' => 'required',
                'sala_id' => 'required' ,
                'professor_id' => 'required' ,
                'professor_id' => new ValidarAulaProfessor,
                'sala_id' => new ValidarAula,
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
