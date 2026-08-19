MenuPro — Guia de Desenvolvimento

Este documento explica como configurar o ambiente, executar o projeto e trabalhar em equipe.

1. Ambiente

O desenvolvimento atual utiliza Windows e envolve:

Git

GitHub

Laragon

PHP

Composer

MySQL

HeidiSQL

Node.js / npm

Visual Studio Code

Laravel

Vite

As versões exatas devem ser verificadas no composer.json, package.json e arquivos de configuração do projeto.

2. Antes de começar

O desenvolvedor deve:

ter uma conta no GitHub;

aceitar o convite para o repositório;

ter acesso ao repositório;

instalar as ferramentas necessárias;

clonar o projeto;

criar seu ambiente local;

nunca compartilhar credenciais privadas.

3. Ferramentas

Git

git --version

Configuração:

git config --global user.name "SEU NOME"
git config --global user.email "SEU EMAIL DO GITHUB"

PHP

php -v

Use a versão compatível com o composer.json.

Composer

composer -V

Node/npm

node -v
npm -v

Laragon

Instalar e iniciar os serviços necessários, especialmente Apache e MySQL.

HeidiSQL

Usado para consultar e administrar o MySQL.

VS Code

Abrir a pasta do projeto.

4. Clonar o projeto

No GitHub, copiar o endereço em:

Code → HTTPS

No terminal:

cd C:\laragon\www
git clone URL_DO_REPOSITORIO
cd menuPro

Substitua menuPro pelo nome real da pasta, se necessário.

5. Dependências PHP

composer install

Na instalação inicial, prefira composer install.

Evite composer update sem necessidade, pois ele pode alterar versões das dependências.

6. Dependências JavaScript

npm install

7. .env

Se existir .env.example:

copy .env.example .env

Depois:

php artisan key:generate

O .env contém configurações locais e possíveis credenciais. Nunca o envie ao GitHub.

8. Banco

Criar um banco local:

menupro

Configuração típica:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=menupro
DB_USERNAME=root
DB_PASSWORD=

O usuário e a senha devem corresponder ao MySQL local.

9. Migrations

Antes de executar comandos destrutivos, verificar as migrations existentes.

Evitar sem autorização:

php artisan migrate:fresh
php artisan db:wipe

Esses comandos podem apagar dados locais.

Não assumir que migrate --seed reproduz exatamente o banco atual sem conferir os seeders.

10. Storage

php artisan storage:link

11. Cache

php artisan optimize:clear

12. Executar Laravel

Terminal 1:

php artisan serve

Normalmente a aplicação fica disponível em:

http://127.0.0.1:8000

13. Executar Vite

Terminal 2:

npm run dev

Manter o processo aberto durante o desenvolvimento do frontend.

14. Checklist

[ ] Git instalado
[ ] GitHub configurado
[ ] Convite aceito
[ ] Laragon instalado
[ ] Apache funcionando
[ ] MySQL funcionando
[ ] PHP funcionando
[ ] Composer funcionando
[ ] Node.js funcionando
[ ] npm funcionando
[ ] Projeto clonado
[ ] composer install executado
[ ] npm install executado
[ ] .env criado
[ ] APP_KEY gerada
[ ] Banco menupro criado
[ ] Banco configurado
[ ] storage:link executado
[ ] optimize:clear executado
[ ] php artisan serve funcionando
[ ] npm run dev funcionando
[ ] Aplicação abre no navegador

15. Git — regra principal

A main deve representar uma versão estável.

Não desenvolver diretamente na main.

Criar uma branch por tarefa.

Exemplo:

git checkout main
git pull origin main
git checkout -b feature/admin-pedidos

16. Atualizar antes de começar

git checkout main
git pull origin main

Depois:

git checkout feature/admin-pedidos

Se a branch já existir:

git pull origin feature/admin-pedidos

17. Convenção de branches

Funcionalidades:

feature/nome-da-funcionalidade

Exemplos:

feature/admin-pedidos
feature/status-pedidos
feature/dashboard

Correções:

fix/nome-do-problema

Exemplo:

fix/calculo-adicionais

18. Commits

Preferir commits pequenos e objetivos.

Exemplos:

git add .
git commit -m "feat: cria listagem administrativa de pedidos"

git commit -m "fix: corrige calculo dos adicionais"

git commit -m "refactor: organiza consulta dos pedidos"

19. Push

git push -u origin feature/admin-pedidos

Depois abrir um Pull Request no GitHub.

20. Pull Request

Descrever:

O que foi feito

Exemplo:

Criada a listagem administrativa de pedidos.

O que foi alterado

- Controller
- Route
- View
- Consulta dos pedidos

Como foi testado

- Pedido criado pelo cardápio público
- Pedido apareceu na listagem
- Detalhes conferidos

Pendências

- Status ainda será implementado

21. Conflitos

Se houver conflito:

git status

Analise os arquivos conflitantes antes de resolver.

Não apagar alterações do outro desenvolvedor sem entender o conflito.

22. Banco de dados

Mudanças estruturais devem ser feitas por migration.

Exemplo:

php artisan make:migration add_status_to_orders_table

Evite alterar o banco manualmente no HeidiSQL e deixar a mudança sem registro no código.

23. Investigação de problemas

Fluxo recomendado:

Erro
 ↓
Console do navegador
 ↓
Network
 ↓
Payload
 ↓
Resposta HTTP
 ↓
Validation
 ↓
Backend
 ↓
Banco
 ↓
Correção
 ↓
Novo teste

No navegador:

F12 → Console
F12 → Network

Conferir URL, método, payload, status HTTP e resposta.

24. Exemplo do último problema

As opções chegavam ao backend sem:

option_group_name

A API retornava:

422 Unprocessable Content

A investigação mostrou erro de validação em:

items.*.options.*.option_group_name

A correção foi feita no frontend, passando o nome do grupo pelo input e incluindo:

option_group_name: input.dataset.groupName

Depois disso, o pedido foi criado com sucesso e as opções foram gravadas em order_item_options.

25. Próxima tarefa

A próxima tarefa é:

PAINEL ADMINISTRATIVO DE PEDIDOS

Antes de escrever código, analisar:

routes
app/Http/Controllers
app/Models
app/Http/Requests
resources/views/admin
migrations/orders*
migrations/order_items*
migrations/order_item_options*

Depois definir:

Route
 ↓
Controller
 ↓
Model / Query
 ↓
View

26. Primeira tarefa do desenvolvedor administrativo

Criar:

git checkout main
git pull origin main
git checkout -b feature/admin-pedidos

Depois:

localizar o módulo administrativo;

localizar controllers administrativos;

localizar views administrativas;

localizar Order;

localizar OrderItem;

localizar OrderItemOption;

verificar relações dos Models;

verificar rotas;

apresentar a estrutura encontrada;

somente então implementar a listagem.

27. Uso de IA

Fazer

fornecer o arquivo atual;

fornecer o erro;

informar o resultado esperado;

pedir análise antes da alteração;

aplicar alterações pequenas;

testar após cada alteração.

Evitar

pedir para a IA reescrever o projeto;

substituir arquivos inteiros sem necessidade;

criar Models que já existem;

criar migrations duplicadas;

inventar nomes de tabelas;

alterar contratos de API sem necessidade;

executar comandos destrutivos sem entender o efeito.

28. Princípio do MenuPro

Código existente primeiro. Código novo depois.

Toda nova funcionalidade deve se encaixar no projeto existente, e não obrigar o projeto a se adaptar a uma implementação criada do zero.