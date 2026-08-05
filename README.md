MenuZurix - Guia de Configuração do Ambiente

Visão geral

Projeto de cardápio digital desenvolvido em Laravel.

Versão estável atual: v0.1-estavel

Pré-requisitos

Instalar:

PHP 8.4+

Composer

Node.js e NPM

Git

Laragon

HeidiSQL

Visual Studio Code

Verificar:

php -v
composer -V
node -v
npm -v
git --version

Instalação

Clonar:

git clone https://github.com/TiagoGodSide/MenuZurix.git
cd MenuZurix

Instalar dependências:

composer install
npm install

Criar ambiente:

copy .env.example .env
php artisan key:generate

Banco de dados

No Laragon:

iniciar Apache

iniciar MySQL

Criar banco no HeidiSQL:

menuzurix

Configurar .env:

DB_DATABASE=menuzurix
DB_USERNAME=root
DB_PASSWORD=

Executar:

php artisan migrate
php artisan db:seed

Imagens

Executar:

php artisan storage:link

Rodando o projeto

Terminal 1:

php artisan serve

Terminal 2:

npm run dev

Acesso:

http://127.0.0.1:8000

Git

Atualizar:

git pull

Criar branch:

git checkout -b feature/nome-da-tarefa

Enviar:

git add .
git commit -m "descrição"
git push origin feature/nome-da-tarefa

Regras

Não trabalhar diretamente na main.

Não enviar .env.

Não enviar vendor.

Não enviar node_modules.

Sempre usar branches.

Estado atual

Funcionando:

Cadastro de negócio

Categorias

Produtos

Upload de imagens

Cardápio público

Tag:

v0.1-estavel