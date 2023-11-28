<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $fillable = ['titulo','grupo_disciplina_id'] ;

    public function grupoDisciplina()
    {
        return $this->belongsTo(GrupoDisciplina::class, 'grupo_disciplina_id');
    }
}
