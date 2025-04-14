# Sistema de Cadastro de Funcionários com Exportação Excel

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel)](https://laravel.com)
[![Docker](https://img.shields.io/badge/Docker-✓-2496ED?logo=docker)](https://www.docker.com/)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql)](https://www.mysql.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?logo=tailwind-css)](https://tailwindcss.com/)

Sistema de cadastro de funcionários com validação de dados e funcionalidade de exportação para Excel (XLS). Desenvolvido com Laravel 10 e Docker.

## ✨ Funcionalidades

- ✅ Cadastro de funcionários com validação de campos
- ✅ Atribuição de variáveis/campos aos registros
- ✅ Exportação de dados para formato Excel (.xls)
- ✅ Interface responsiva com Tailwind CSS
- ✅ Ambiente Dockerizado para desenvolvimento
- ✅ Banco de dados MySQL

## 🚀 Requisitos

- Docker e Docker Compose
- PHP 8.1+
- Composer

## ⚙️ Instalação

1. Clone o repositório:

```bash
git clone [URL_DO_REPOSITORIO]
cd [NOME_DO_PROJETO]

    Configure o ambiente:
```

```bash
Copy

cp .env.example .env

    Suba os containers:
```

```bash
Copy

docker-compose up -d

    Instale as dependências:
```

```bash
Copy

docker-compose exec app composer install

    Gere a chave da aplicação:
```

```bash

docker-compose exec app php artisan key:generate

    Execute as migrações:
```

```bash

docker-compose exec app php artisan migrate
```

Acesse a aplicação:
<http://localhost:8000>

🛠️ Tecnologias Utilizadas

Backend: Laravel 10

Frontend: Tailwind CSS 3

Banco de Dados: MySQL 8

Containerização: Docker

Exportação Excel: Laravel Excel ou biblioteca similar

📝 Estrutura do Projeto
Copy

├── app/               # Lógica da aplicação
├── bootstrap/         # Inicialização
├── config/            # Configurações
├── database/          # Migrações e seeds
├── public/            # Assets públicos
├── resources/         # Views e assets
├── routes/            # Rotas
├── storage/           # Armazenamento
├── tests/             # Testes
├── vendor/            # Dependências
└── docker/            # Configurações Docker

📌 Variáveis de Ambiente

Principais variáveis que precisam ser configuradas no .env:
ini
Copy

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha

📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.
