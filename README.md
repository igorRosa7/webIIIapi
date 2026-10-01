# Biblioteca API

API REST em **Laravel** para consultar e gerenciar **livros**, **autores** e **categorias**. Todas as respostas são em **JSON**, o banco é **MySQL/MariaDB** (criado por migrations) e a autenticação usa **Laravel Sanctum**.

## Tecnologias

- PHP 8.2+
- Laravel 12
- MySQL ou MariaDB
- Laravel Sanctum (autenticação por token)

## Banco de dados

```
autor (1) ──── (N) livro (N) ──── (1) categoria
```

| Tabela | Campos |
|---|---|
| `autor` | `idautor`, `nome`, `nacionalidade`, `nascimento`, `biografia` |
| `categoria` | `idcategoria`, `nome`, `descricao` |
| `livro` | `idlivro`, `titulo`, `isbn`, `anopublicacao`, `descricao`, `paginas`, `idautor`, `idcategoria` |

## Organização do código

Cada requisição passa por três camadas:

```
Rota → Controller → Service → Repository → Model (banco)
```

| Camada | Pasta | Responsabilidade |
|---|---|---|
| **Controller** | `app/Http/Controllers` | Recebe a requisição, valida os dados e devolve a resposta HTTP |
| **Service** | `app/Services` | Regras de negócio (ex.: não excluir autor com livros, usuário só altera a própria conta) |
| **Repository** | `app/Repositories` | Acesso ao banco. O `BaseRepository` tem as operações comuns (listar, buscar, criar, atualizar, excluir) |
| **Model** | `app/Models` | Representa as tabelas e os relacionamentos |

## Como rodar

```bash
composer install
cp .env.example .env
php artisan key:generate
```

No `.env`, configure o banco:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca
DB_USERNAME=root
DB_PASSWORD=
```

Crie o banco `biblioteca` no MySQL e rode:

```bash
php artisan migrate --seed   # cria as tabelas e os dados de exemplo
php artisan serve            # inicia em http://127.0.0.1:8000
```

Usuário de exemplo criado pelo seed: `test@example.com` / `password`.

## Autenticação

As consultas (**GET**) são públicas. Cadastro, alteração e exclusão (**POST, PUT, DELETE**) exigem token.

1. Faça login em `POST /api/login` (ou cadastre-se em `POST /api/register`).
2. Copie o `token` da resposta.
3. Envie nas próximas requisições o header `Authorization: Bearer {token}`.

Envie também `Accept: application/json` em todas as requisições.

## Endpoints

| Método | Rota | Descrição | Token |
|---|---|---|---|
| POST | `/api/register` | Cadastra um usuário e retorna o token | Não |
| POST | `/api/login` | Faz login e retorna o token | Não |
| POST | `/api/logout` | Revoga o token atual | Sim |
| GET | `/api/user` | Dados do usuário logado | Sim |
| GET | `/api/autores` | Lista os autores | Não |
| GET | `/api/autores/{id}` | Retorna um autor | Não |
| POST | `/api/autores` | Cadastra um autor | Sim |
| PUT | `/api/autores/{id}` | Atualiza um autor | Sim |
| DELETE | `/api/autores/{id}` | Remove um autor | Sim |
| GET | `/api/categorias` | Lista as categorias | Não |
| GET | `/api/categorias/{id}` | Retorna uma categoria | Não |
| POST | `/api/categorias` | Cadastra uma categoria | Sim |
| PUT | `/api/categorias/{id}` | Atualiza uma categoria | Sim |
| DELETE | `/api/categorias/{id}` | Remove uma categoria | Sim |
| GET | `/api/livros` | Lista os livros **com autor e categoria** | Não |
| GET | `/api/livros/{id}` | Retorna um livro **com autor e categoria** | Não |
| POST | `/api/livros` | Cadastra um livro | Sim |
| PUT | `/api/livros/{id}` | Atualiza um livro | Sim |
| DELETE | `/api/livros/{id}` | Remove um livro | Sim |
| GET | `/api/users` | Lista os usuários | Sim |
| GET | `/api/users/{id}` | Retorna um usuário | Sim |
| PUT | `/api/users/{id}` | Atualiza a **própria** conta (senha opcional) | Sim |
| DELETE | `/api/users/{id}` | Exclui a **própria** conta | Sim |

O cadastro de usuários é feito pelo `POST /api/register`.

### Exemplo: cadastrar um livro

```http
POST /api/livros
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json

{
  "titulo": "A Revolução dos Bichos",
  "isbn": "978-8535909555",
  "anopublicacao": 1945,
  "descricao": "Fábula sobre poder e corrupção.",
  "paginas": 152,
  "idautor": 2,
  "idcategoria": 2
}
```

### Exemplo: resposta de `GET /api/livros/1`

```json
{
  "idlivro": 1,
  "titulo": "Dom Casmurro",
  "isbn": "978-8535910667",
  "anopublicacao": 1899,
  "descricao": "Bentinho relembra sua vida e o ciúme por Capitu.",
  "paginas": 256,
  "idautor": 1,
  "idcategoria": 1,
  "autor": {
    "idautor": 1,
    "nome": "Machado de Assis",
    "nacionalidade": "Brasileira",
    "nascimento": "1839-06-21",
    "biografia": "Escritor brasileiro, fundador da Academia Brasileira de Letras."
  },
  "categoria": {
    "idcategoria": 1,
    "nome": "Romance",
    "descricao": "Obras de ficção em prosa."
  }
}
```

## Códigos de resposta

| Código | Quando |
|---|---|
| 200 | Consulta ou atualização feita |
| 201 | Registro criado |
| 204 | Registro excluído |
| 401 | Sem token, token inválido ou login incorreto |
| 403 | Tentativa de alterar ou excluir a conta de outro usuário |
| 404 | Registro não encontrado |
| 409 | Exclusão de autor ou categoria que ainda tem livros |
| 422 | Dados inválidos (a resposta lista os erros de cada campo) |

## Postman

A collection está em [`docs/biblioteca-api.postman_collection.json`](docs/biblioteca-api.postman_collection.json). No Postman, clique em **Import** e selecione o arquivo.

- Rode **Auth > Login** primeiro: o token é salvo automaticamente e usado nas outras requisições.
- **Cadastrar** salva o id criado, que é usado em **Atualizar** e **Excluir**.
- Para testar a API publicada, altere a variável `base_url` da collection.
