<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = ['titulo','status','desc_status'];

    public function getDescStatusAttribute()
    {
        return $this->status ? 'SIM' : 'NÃO' ;
    }
}
