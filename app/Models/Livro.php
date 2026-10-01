<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $table = 'livro';
    protected $primaryKey = 'idlivro';
    public $timestamps = false;

    protected $fillable = ['titulo', 'isbn', 'anopublicacao', 'descricao', 'paginas', 'idautor', 'idcategoria'];

    public function autor()
    {
        return $this->belongsTo(Autor::class, 'idautor', 'idautor');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idcategoria', 'idcategoria');
    }
}
