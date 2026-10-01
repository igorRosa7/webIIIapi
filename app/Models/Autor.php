<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autor';
    protected $primaryKey = 'idautor';
    public $timestamps = false;

    protected $fillable = ['nome', 'nacionalidade', 'nascimento', 'biografia'];

    public function livros()
    {
        return $this->hasMany(Livro::class, 'idautor', 'idautor');
    }
}
