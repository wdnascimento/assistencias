<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabelaCodes extends Model
{
    protected $fillable = ['pai','item','valor','descricao'];
}
