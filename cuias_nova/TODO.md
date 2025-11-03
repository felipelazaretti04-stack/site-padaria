# TODO: Desenvolvimento do Site de E-commerce CuiasLazaretti

## 1. Criar Estrutura de Pastas
- [x] Criar pastas: assets/css, assets/js, assets/img, includes, admin, pages, api

## 2. Banco de Dados
- [x] Criar cuiaslazaretti_db.sql com tabelas: usuarios, produtos, pedidos, itens_pedido, enderecos
- [x] Incluir dados iniciais (ex: produtos de exemplo)

## 3. Includes Comuns
- [x] includes/db_connect.php: Conexão PDO com MySQL
- [x] includes/header.php: Cabeçalho HTML com navegação
- [x] includes/footer.php: Rodapé HTML

## 4. Páginas Principais (PHP gerando HTML)
- [x] index.php: Home com carrossel e produtos em destaque
- [x] pages/produtos.php: Lista de produtos com filtros
- [x] pages/produto_detalhe.php: Detalhes de um produto
- [x] pages/carrinho.php: Visualizar e editar carrinho (usando sessões)
- [x] pages/checkout.php: Formulário de checkout e finalização
- [x] pages/contato.php: Página de contato

## 5. APIs/Ações (Scripts PHP para ações)
- [x] api/adicionar_carrinho.php: Adicionar produto ao carrinho (via POST, redireciona)
- [x] api/remover_carrinho.php: Remover item do carrinho
- [x] api/calcular_frete.php: Calcular frete (integrar API externa)
- [x] api/finalizar_pedido.php: Gravar pedido no banco

## 6. Painel Administrativo
- [x] admin/login.php: Página de login
- [x] admin/index.php: Dashboard admin (protegido por sessão)
- [x] admin/produtos.php: CRUD de produtos (cadastrar, editar, remover, upload imagem)
- [x] admin/pedidos.php: Listar pedidos e atualizar status

## 7. Assets
- [x] assets/css/style.css: Estilos customizados (tema marrom/bege, responsivo com Bootstrap)
- [x] assets/js/app.js: Scripts JS para interações (ex: atualizar quantidade no carrinho)
- [x] assets/img/: Adicionar imagens placeholders (logo, produtos, banners)

## 8. Testes e Ajustes
- [ ] Executar SQL no MySQL
- [ ] Testar navegação e funcionalidades localmente
- [ ] Ajustar responsividade e design
- [ ] Adicionar opcionais se necessário (busca, filtros, integração PagSeguro)
