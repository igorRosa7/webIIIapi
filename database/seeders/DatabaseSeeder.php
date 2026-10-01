<?php

namespace Database\Seeders;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // O seed roda a cada deploy, então só popula um banco vazio
        if (Autor::exists()) {
            return;
        }

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password'],
        );

        $machado = Autor::create([
            'nome' => 'Machado de Assis',
            'nacionalidade' => 'Brasileira',
            'nascimento' => '1839-06-21',
            'biografia' => 'Escritor brasileiro, fundador da Academia Brasileira de Letras.',
        ]);
        $orwell = Autor::create([
            'nome' => 'George Orwell',
            'nacionalidade' => 'Britânica',
            'nascimento' => '1903-06-25',
            'biografia' => 'Escritor e jornalista inglês.',
        ]);

        $romance = Categoria::create(['nome' => 'Romance', 'descricao' => 'Obras de ficção em prosa.']);
        $distopia = Categoria::create(['nome' => 'Distopia', 'descricao' => 'Ficção sobre sociedades opressivas.']);

        Livro::create([
            'titulo' => 'Dom Casmurro',
            'isbn' => '978-8535910667',
            'anopublicacao' => 1899,
            'descricao' => 'Bentinho relembra sua vida e o ciúme por Capitu.',
            'paginas' => 256,
            'idautor' => $machado->idautor,
            'idcategoria' => $romance->idcategoria,
        ]);
        Livro::create([
            'titulo' => 'Memórias Póstumas de Brás Cubas',
            'isbn' => '978-8535911664',
            'anopublicacao' => 1881,
            'descricao' => 'Um defunto autor narra sua própria vida.',
            'paginas' => 208,
            'idautor' => $machado->idautor,
            'idcategoria' => $romance->idcategoria,
        ]);
        Livro::create([
            'titulo' => '1984',
            'isbn' => '978-8535914849',
            'anopublicacao' => 1949,
            'descricao' => 'Um regime totalitário vigia todos os cidadãos.',
            'paginas' => 416,
            'idautor' => $orwell->idautor,
            'idcategoria' => $distopia->idcategoria,
        ]);
    }
}
