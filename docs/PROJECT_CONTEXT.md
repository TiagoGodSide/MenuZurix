Zurix Menu — Contexto do Projeto

Documento de contexto técnico para manter a continuidade do desenvolvimento do MenuPro.

Objetivo: permitir que qualquer desenvolvedor ou novo chat de IA entenda o estado atual do projeto sem depender do histórico de uma conversa.

1. Visão geral

O MenuPro é um sistema de cardápio digital para estabelecimentos.

O projeto possui uma área pública, onde o cliente consulta o cardápio e realiza pedidos, e uma área administrativa, que será responsável pelo gerenciamento operacional dos pedidos e demais recursos do estabelecimento.

Tecnologias identificadas no ambiente atual:

Laravel / PHP

MySQL

Blade

JavaScript

Vite / npm

Git / GitHub

Laragon

HeidiSQL

Visual Studio Code

As versões exatas devem ser conferidas no composer.json, package.json e demais arquivos de configuração do repositório.

2. Arquitetura conceitual

A estrutura observada segue aproximadamente:

Business
 ├── Categories
 │    └── Products
 │         └── Option Groups
 │              └── Option Items
 │
 └── Orders
      ├── Order Items
      │    └── Order Item Options
      └── Dados do cliente / entrega / pagamento

O conceito central é que os dados do cardápio e dos pedidos pertencem a um estabelecimento (business).

3. Banco de dados

Banco utilizado no ambiente de desenvolvimento:

menupro

Tabelas observadas:

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

Também existem tabelas relacionadas ao funcionamento do Laravel, como cache, jobs, migrations, sessões e tokens de recuperação de senha.

Esta lista representa o estado observado no ambiente de desenvolvimento. O schema definitivo deve ser conferido nas migrations do repositório.

4. Área pública

O cardápio público já permite:

visualizar categorias;

visualizar produtos;

selecionar produtos;

abrir as opções de um produto;

selecionar acompanhamentos/opções;

adicionar produtos ao carrinho.

5. Sistema de opções / acompanhamentos

O projeto possui grupos de opções associados aos produtos.

Exemplo observado:

Acompanhamentos
 ├── Leite em Pó
 └── Farinha de paçoca

Frutas
 └── Morango

Os itens possuem informações como:

id
uuid
option_group_id
name
description
additional_price
max_quantity
sort_order
is_default
is_active

6. Carrinho

O carrinho utiliza localStorage e possui lógica para:

recuperar o carrinho;

adicionar produtos;

atualizar quantidade;

calcular preço base;

calcular preço das opções;

calcular subtotal;

exibir opções selecionadas;

preparar os itens para envio ao backend.

7. Estrutura das opções no frontend

As opções selecionadas são normalizadas para uma estrutura equivalente a:

{
    option_item_id,
    option_group_name,
    option_item_name,
    price,
    quantity,
    subtotal
}

8. Checkout

O checkout possui:

Dados

nome;

telefone opcional.

Recebimento

retirar no local;

receber em casa.

Pagamento

PIX;

dinheiro;

cartão.

Observações

Campo de observação geral do pedido.

9. Criação do pedido

O frontend envia:

POST /pedidos

A requisição é validada pelo:

StoreOrderRequest.php

O fluxo envolve:

OrderController.php

e a estrutura de serviços existente relacionada a pedidos.

Antes de alterar esse fluxo, analisar os arquivos atuais e preservar o contrato da API.

10. Último problema resolvido

O frontend estava enviando as opções sem option_group_name.

O backend rejeitava a requisição com erros semelhantes a:

items.0.options.0.option_group_name: validation.required

A correção foi feita no frontend. Na renderização dos inputs das opções foi incluído o nome do grupo em um atributo data-group-name, e a coleta das opções passou a incluir:

option_group_name: input.dataset.groupName

Depois dessa alteração, o pedido foi aceito.

11. Teste de integração concluído

Foi realizado um teste completo no cardápio público.

O pedido foi enviado com sucesso e também foi conferido diretamente no MySQL.

Foram observados registros em:

orders
order_items
order_item_options

Exemplo observado em order_item_options:

Acompanhamentos | Leite em Pó       | 3,00 | 1
Acompanhamentos | Farinha de paçoca | 0,00 | 1
Frutas          | Morango            | 2,00 | 1

Portanto, o fluxo:

Cliente
   ↓
Cardápio
   ↓
Produto
   ↓
Opções
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

está funcionando no ambiente atual.

12. Estado atual

Concluído / funcionando

estrutura do projeto;

banco de dados;

estabelecimentos/businesses;

categorias;

produtos;

imagens de produtos;

grupos de opções;

itens de opções;

associação entre produtos e opções;

cardápio público;

seleção de opções;

carrinho;

cálculo de adicionais;

checkout;

criação do pedido;

persistência do pedido;

persistência dos itens;

persistência das opções dos itens.

Próximo módulo prioritário

Painel administrativo de pedidos.

Ainda precisamos criar a interface administrativa para visualizar e operar os pedidos que já estão chegando ao banco.

O painel deverá, conforme a implementação for definida, permitir visualizar:

identificação do pedido;

data e hora;

cliente;

telefone;

tipo de recebimento;

endereço, quando houver delivery;

forma de pagamento;

observação;

produtos;

quantidades;

opções/acompanhamentos;

preços;

subtotal;

total;

status.

13. Status dos pedidos

Fluxo planejado:

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

Esses status são planejamento. Antes de alterar o banco, verificar se já existe alguma implementação.

14. Dashboard administrativo

Depois do painel de pedidos, está previsto um dashboard com informações como:

pedidos do dia;

pedidos novos;

pedidos em preparo;

pedidos concluídos;

faturamento;

produtos mais vendidos.

Esta etapa ainda é futura.

15. Divisão atual de trabalho

Frente pública

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

painel administrativo de pedidos;

listagem;

detalhes;

filtros;

busca;

status;

operação do pedido;

posteriormente dashboard.

16. Regra de ouro

Antes de modificar qualquer parte existente:

localizar o arquivo;

entender o fluxo atual;

identificar quem chama quem;

verificar o contrato dos dados;

verificar migrations/modelos/requests/controllers relacionados;

fazer a menor alteração necessária;

testar;

só depois refatorar, se necessário.

Não recriar uma funcionalidade que já existe.

Não substituir a arquitetura existente sem necessidade.

Não assumir que um arquivo funciona de determinada maneira sem lê-lo.

17. Próxima tarefa oficial

Construir o painel administrativo de pedidos utilizando os dados que já estão sendo gravados em:

orders
order_items
order_item_options

Primeiro analisar:

app/Http/Controllers/Admin
resources/views/admin
routes
Models relacionados a Order
StoreOrderRequest
OrderController
migrations de orders/order_items/order_item_options

Depois definir a implementação antes de escrever código.

18. Contexto para novos chats de IA

Este arquivo deve ser fornecido como contexto quando um novo chat for iniciado.

O assistente deve:

respeitar a arquitetura existente;

analisar os arquivos antes de propor alterações;

não inventar arquivos, tabelas ou relacionamentos;

distinguir o que está confirmado do que é planejamento;

preservar o fluxo público de pedidos que já funciona;

trabalhar incrementalmente;

explicar alterações antes de solicitar que sejam aplicadas.