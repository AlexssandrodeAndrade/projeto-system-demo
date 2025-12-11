# Projeto System Demo

Aplicação Laravel 12 com Inertia.js e Vue 3 (Starter Kit) para portfolio, incluindo um módulo CRUD de exemplos (nome, descrição, status ativo/inativo) que serve de base para futuros módulos.

## Tecnologias
- PHP 8 / Laravel 12
- Inertia.js + Vue 3 (TypeScript ready) com Vite
- Laravel Starter Kit (auth, 2FA opcional)
- SQLite (database/database.sqlite) para ambiente local

## Como rodar localmente
```bash
cp .env.example .env
php artisan key:generate

# dependências
composer install
npm install

# banco
php artisan migrate --seed  # cria tabela e popular exemplos de demonstração

# servidor backend
php artisan serve
# frontend (Vite)
npm run dev
```
Acesse http://127.0.0.1:8000 e faça login/registro pelo Starter Kit.

## Módulo Exemplo
- Rotas protegidas em `/exemplos` (CRUD completo, filtros de busca e status, paginação).
- Campos: `nome`, `descricao`, `ativo`.
- Validação via FormRequest (`Store/ExemploRequest`, `Update/ExemploRequest`).
- Componentes Inertia em `resources/js/pages/exemplos/*` com formulário reutilizável e modal de exclusão.
- Menu lateral atualizado com link para “Exemplos”.

## Scripts úteis
- `npm run dev` — dev server Vite
- `npm run build` — build de produção
- `php artisan test` — test suite
- `php artisan migrate:fresh --seed` — recria banco local com dados demo

## Estrutura relevante
- `app/Http/Controllers/ExemploController.php` — CRUD, filtros de busca/status
- `app/Http/Requests/Store|Update/ExemploRequest.php` — validação/normalização
- `database/factories/ExemploFactory.php` e `database/seeders/DatabaseSeeder.php`
- `resources/js/pages/exemplos/` — Index, Create, Edit, Form
- `resources/js/components/AppSidebar.vue` — item de menu “Exemplos”

## Publicação
Repositório: https://github.com/AlexssandrodeAndrade/projeto-system-demo

Pronto para usar como vitrine no LinkedIn/GitHub. Substitua textos e personalize o módulo para outro domínio (Clientes/Produtos) se desejar. 
