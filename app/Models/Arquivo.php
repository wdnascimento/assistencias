<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arquivo extends Model
{
    use HasFactory, SoftDeletes;

    // id, titulo, data_hora, importado, usuario, deleted_at, created_at, updated_at
    protected $fillable = ['titulo', 'data_hora', 'importado', 'usuario'];

    public function getDescImportadoAttribute()
    {
        return $this->importado ? 'SIM' : 'NÃO' ;
    }
}
