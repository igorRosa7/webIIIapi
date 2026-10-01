# Biblioteca API

API REST em **Laravel 12** para gerenciar **livros**, **autores**, **categorias** e **usuários**. Respostas em **JSON**, banco **MySQL** criado por migrations e autenticação com **Laravel Sanctum**.

**API publicada:** https://webiiiapi-production.up.railway.app/api/livros

## Banco de dados

```
autor (1) ──── (N) livro (N) ──── (1) categoria
```

O código segue o fluxo `Controller → Service → Repository → Model`.

## Como rodar localmente

```bash
composer install
cp .env.example .env        # configure o MySQL e crie o banco "biblioteca"
php artisan key:generate
php artisan migrate --seed  # cria as tabelas e os dados de exemplo
php artisan serve           # http://127.0.0.1:8000
```

Usuário de exemplo: `test@example.com` / `password`.

## Autenticação

Consultas (**GET**) de autores, categorias e livros são públicas. **POST, PUT e DELETE** exigem token:

1. Faça login em `POST /api/login` (ou cadastre-se em `POST /api/register`).
2. Envie o token recebido no header `Authorization: Bearer {token}`.

Envie também `Accept: application/json` em todas as requisições.

## Endpoints

| Método | Rota | Descrição | Token |
|---|---|---|---|
| POST | `/api/register` | Cadastra um usuário | Não |
| POST | `/api/login` | Faz login e retorna o token | Não |
| POST | `/api/logout` | Revoga o token atual | Sim |
| GET | `/api/user` | Usuário logado | Sim |
| GET | `/api/autores` · `/api/autores/{id}` | Lista / busca autores | Não |
| POST | `/api/autores` | Cadastra um autor | Sim |
| PUT · DELETE | `/api/autores/{id}` | Atualiza / remove um autor | Sim |
| GET | `/api/categorias` · `/api/categorias/{id}` | Lista / busca categorias | Não |
| POST | `/api/categorias` | Cadastra uma categoria | Sim |
| PUT · DELETE | `/api/categorias/{id}` | Atualiza / remove uma categoria | Sim |
| GET | `/api/livros` · `/api/livros/{id}` | Lista / busca livros **com autor e categoria** | Não |
| POST | `/api/livros` | Cadastra um livro | Sim |
| PUT · DELETE | `/api/livros/{id}` | Atualiza / remove um livro | Sim |
| GET | `/api/users` · `/api/users/{id}` | Lista / busca usuários | Sim |
| PUT · DELETE | `/api/users/{id}` | Atualiza / exclui a **própria** conta | Sim |

Autores e categorias com livros vinculados não podem ser excluídos (`409`).

## Postman

Importe [`docs/biblioteca-api.postman_collection.json`](docs/biblioteca-api.postman_collection.json) no Postman e rode **Auth > Login** primeiro: o token é salvo e usado nas demais requisições. A variável `base_url` aponta para a API publicada; troque para `http://127.0.0.1:8000` para testar localmente.
