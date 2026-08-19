🍽️ Zurix Menu

Sistema de cardápio digital e gerenciamento de pedidos para estabelecimentos.

O Zurix Menu permite que o estabelecimento disponibilize seu cardápio de forma digital, com produtos, categorias e opções/acompanhamentos, permitindo que o cliente monte o pedido diretamente pela interface pública.

O projeto está em desenvolvimento incremental, com foco em uma arquitetura organizada, manutenção simples e evolução gradual do sistema.

📌 Status do projeto

Em desenvolvimento 🚧

O fluxo principal de pedidos da área pública já está funcionando.

Atualmente, o cliente consegue:

acessar o cardápio;

navegar pelas categorias;

visualizar produtos;

selecionar opções e acompanhamentos;

adicionar produtos ao carrinho;

revisar o pedido;

escolher forma de recebimento;

escolher forma de pagamento;

adicionar observações;

enviar o pedido.

O pedido é persistido no banco de dados juntamente com seus itens e respectivas opções.

Próximo grande módulo

Painel administrativo de pedidos

A próxima etapa é construir a área administrativa para que o estabelecimento possa visualizar e operar os pedidos recebidos.

🧩 Tecnologias

O projeto utiliza as seguintes tecnologias:

PHP

Laravel

MySQL

Blade

JavaScript

Node.js / npm

Vite

Git / GitHub

Laragon

HeidiSQL

Visual Studio Code

As versões exatas devem ser verificadas diretamente no composer.json, package.json e demais arquivos de configuração do projeto.

🏗️ Estrutura conceitual

A estrutura de negócio do MenuPro segue, atualmente, este conceito:

Business
 ├── Categories
 │    └── Products
 │         └── Option Groups
 │              └── Option Items
 │
 └── Orders
      ├── Order Items
      │    └── Order Item Options
      │
      └── Dados do cliente
           ├── Recebimento
           ├── Entrega
           ├── Pagamento
           └── Observações

🗄️ Banco de dados

O banco utilizado no ambiente de desenvolvimento é:

menupro

Entre as tabelas observadas no projeto estão:

business_users
businesses
categories
option_groups
option_group_product
option_items
order_item_options
order_items
orders
product_images
products
users

Além das tabelas utilizadas pelo próprio Laravel.

A estrutura definitiva do banco deve sempre ser conferida nas migrations do projeto.

🛒 Fluxo atual de pedidos

O fluxo público atualmente funciona da seguinte maneira:

Cliente
   ↓
Cardápio
   ↓
Categoria
   ↓
Produto
   ↓
Opções / Acompanhamentos
   ↓
Carrinho
   ↓
Checkout
   ↓
POST /pedidos
   ↓
Validação
   ↓
orders
   ↓
order_items
   ↓
order_item_options

Esse fluxo já foi testado de ponta a ponta no ambiente de desenvolvimento.

🧂 Sistema de opções

Os produtos podem possuir grupos de opções.

Exemplo:

Acompanhamentos
 ├── Leite em Pó
 └── Farinha de paçoca

Frutas
 └── Morango

As opções podem possuir:

nome;

descrição;

preço adicional;

quantidade máxima;

ordem;

configuração padrão;

status ativo/inativo.

Os valores das opções são considerados no cálculo do pedido.

🛍️ Carrinho

O carrinho é controlado no frontend utilizando localStorage.

O sistema já possui lógica para:

adicionar produtos;

alterar quantidade;

recuperar o carrinho;

selecionar opções;

calcular adicionais;

calcular subtotais;

preparar o pedido para envio.

💳 Checkout

O checkout atualmente contempla:

Recebimento

Retirar no local

Receber em casa

Pagamento

PIX

Dinheiro

Cartão

Observações

O cliente também pode informar uma observação geral para o estabelecimento.

✅ Integração com o backend

O frontend envia o pedido através de:

POST /pedidos

A requisição é validada pelo:

StoreOrderRequest.php

e processada pelo fluxo relacionado ao:

OrderController.php

Os dados são persistidos em:

orders
order_items
order_item_options

🧪 Teste de integração

O fluxo completo já foi validado.

Um pedido real de teste foi enviado pelo cardápio público e conferido diretamente no MySQL.

Foram encontrados:

registro do pedido;

registros dos produtos;

registros das opções selecionadas.

Exemplo de opções persistidas:

Acompanhamentos | Leite em Pó       | R$ 3,00
Acompanhamentos | Farinha de paçoca | R$ 0,00
Frutas          | Morango            | R$ 2,00

Isso confirma que o fluxo:

Frontend → Backend → Banco

está funcionando para a criação de pedidos.

📋 Roadmap

Fase 1 — Fundação

Estrutura inicial do projeto

Banco de dados

Businesses

Categorias

Produtos

Imagens de produtos

Grupos de opções

Itens de opções

Associação de opções aos produtos

Fase 2 — Cardápio público

Categorias

Produtos

Seleção de opções

Carrinho

Cálculo de adicionais

Checkout

Envio do pedido

Fase 3 — Persistência

Criar pedido

Criar itens do pedido

Criar opções dos itens

Testar integração com MySQL

Fase 4 — Painel administrativo

Listagem de pedidos

Visualização dos detalhes

Produtos do pedido

Opções/acompanhamentos

Informações do cliente

Forma de recebimento

Endereço de entrega

Forma de pagamento

Observações

Total do pedido

Status do pedido

Filtros

Busca

Fase 5 — Operação dos pedidos

Planejamento atual:

Novo
  ↓
Confirmado
  ↓
Em preparo
  ↓
Pronto
  ↓
Entregue

Também deverá existir:

Cancelado

Os status ainda precisam ser analisados no código antes de qualquer alteração no banco.

Fase 6 — Dashboard

Planejamento futuro:

Pedidos do dia

Pedidos novos

Pedidos em preparo

Pedidos concluídos

Faturamento

Produtos mais vendidos

👥 Desenvolvimento em equipe

O projeto está sendo desenvolvido de forma colaborativa através do GitHub.

Frente pública

Responsável por:

cardápio;

categorias;

produtos;

opções;

carrinho;

checkout;

experiência do cliente;

responsividade;

correções do frontend público.

Frente administrativa

Responsável por:

painel administrativo;

listagem de pedidos;

detalhes;

filtros;

busca;

status;

operação dos pedidos;

posteriormente dashboard.

A divisão pode ser ajustada conforme o projeto evoluir.

🌿 Estratégia de branches

A main deve representar uma versão estável.

Não desenvolver diretamente na main.

Criar uma branch para cada tarefa.

Feature

feature/nome-da-funcionalidade

Exemplos:

feature/admin-pedidos
feature/status-pedidos
feature/dashboard

Correção

fix/nome-do-problema

Exemplo:

fix/calculo-adicionais

🔄 Fluxo de trabalho

Antes de começar uma tarefa:

git checkout main
git pull origin main

Criar a branch:

git checkout -b feature/minha-tarefa

Depois do desenvolvimento:

git add .
git commit -m "feat: descreve a alteração"

Enviar para o GitHub:

git push -u origin feature/minha-tarefa

Depois abrir um Pull Request.

🧪 Boas práticas

Antes de modificar uma funcionalidade existente:

localizar o arquivo;

entender o fluxo atual;

identificar as dependências;

verificar Models, migrations, Requests, Controllers e Views relacionados;

fazer a menor alteração necessária;

testar;

somente depois considerar uma refatoração.

Evitar

recriar funcionalidades que já existem;

criar Models duplicados;

criar migrations duplicadas;

inventar tabelas;

alterar contratos da API sem necessidade;

substituir arquivos inteiros sem entender o código;

executar comandos destrutivos no banco sem necessidade.

🤖 Desenvolvimento com IA

O projeto pode utilizar IA como assistente de desenvolvimento.

A regra principal é:

Código existente primeiro. Código novo depois.

Ao iniciar um trabalho com IA, forneça:

o arquivo atual;

o erro encontrado;

o comportamento esperado;

os arquivos relacionados;

o resultado dos testes.

A IA deve analisar a implementação existente antes de propor alterações.

Evite solicitar:

"Reescreva todo o sistema."

Prefira:

"Analise este fluxo existente e faça a menor alteração necessária para implementar X."

📚 Documentação do projeto

Documentos importantes:

Contexto do projeto

docs/PROJECT_CONTEXT.md

Contém o estado atual do desenvolvimento, arquitetura, funcionalidades concluídas e roadmap.

Guia de desenvolvimento

docs/DEVELOPMENT_GUIDE.md

Contém instruções para configurar o ambiente, executar o projeto e trabalhar com Git/GitHub.

🚀 Configuração rápida

Depois de clonar o projeto:

composer install
npm install

Criar o .env:

copy .env.example .env

Gerar a chave:

php artisan key:generate

Configurar o banco menupro no .env.

Depois:

php artisan storage:link
php artisan optimize:clear

Executar o Laravel:

php artisan serve

Em outro terminal:

npm run dev

⚠️ Atenção ao banco

Não executar sem entender o efeito:

php artisan migrate:fresh

ou:

php artisan db:wipe

Esses comandos podem apagar dados do banco local.

Alterações estruturais no banco devem ser registradas através de migrations.

🔍 Investigação de problemas

Quando algo não funcionar, seguir esta ordem:

Problema
   ↓
Console do navegador
   ↓
Network
   ↓
Payload
   ↓
Resposta HTTP
   ↓
Laravel
   ↓
Banco de dados
   ↓
Correção
   ↓
Novo teste

Esse procedimento evita alterações aleatórias no código.

🎯 Próximo objetivo

O próximo grande objetivo do MenuPro é transformar os pedidos que já estão sendo registrados no banco em uma operação administrativa completa.

Cardápio público
      ↓
Pedido recebido
      ↓
Banco de dados
      ↓
Painel administrativo
      ↓
Operação do pedido
      ↓
Status
      ↓
Conclusão

📄 Documentação

docs/PROJECT_CONTEXT.md

docs/DEVELOPMENT_GUIDE.md

📌 Princípio do projeto

Construir de forma incremental, preservar o que funciona e entender o código antes de alterá-lo.

MenuPro — Cardápio digital e gerenciamento de pedidos.