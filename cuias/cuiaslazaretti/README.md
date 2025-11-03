# CuiasLazaretti - E-commerce de Cuias e Bombas

Site de e-commerce completo para venda de cuias, bombas e kits personalizados.

## Funcionalidades

### Cliente
- Visualização de produtos com fotos, nome, preço e descrição
- Adição de itens ao carrinho (via AJAX)
- Cálculo automático de frete
- Finalização de pedido com registro no banco
- Confirmação visual do pedido

### Administrador
- Login protegido
- CRUD completo de produtos
- Visualização de pedidos recebidos
- Atualização de status dos pedidos
- Upload de imagens de produtos

## Tecnologias
- Frontend: HTML5, CSS3 (Bootstrap), JavaScript (AJAX)
- Backend: PHP com PDO
- Banco: MySQL (InnoDB com chaves estrangeiras)

## Estrutura de Pastas
```
cuiaslazaretti/
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
├── includes/
│   ├── db_connect.php
│   ├── header.php
│   └── footer.php
├── admin/
│   ├── index.php
│   ├── login.php
│   ├── produtos.php
│   ├── pedidos.php
│   └── ...
├── pages/
│   ├── home.php
│   ├── produtos.php
│   ├── produto_detalhe.php
│   ├── carrinho.php
│   ├── checkout.php
│   └── contato.php
├── api/
│   ├── adicionar_carrinho.php
│   ├── calcular_frete.php
│   └── ...
├── index.php
└── database.sql
```

## Instalação

1. Importe o arquivo `database.sql` no MySQL
2. Configure as credenciais do banco em `includes/db_connect.php`
3. Acesse o site via `index.php`
4. Para admin, acesse `admin/login.php`

## Tema
- Cores: Marrom e bege, inspirado na madeira e tradição gaúcha
- Layout responsivo e moderno

## Segurança
- Prepared statements para prevenir SQL Injection
- Sessões protegidas para admin
- Validação de entrada de dados
