<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

$routes->get('/', 'Home::index');

/*
|--------------------------------------------------------------------------
| PRODUTOS
|--------------------------------------------------------------------------
*/

$routes->get('/produtos', 'ProdutoController::index');

/*
|--------------------------------------------------------------------------
| CARRINHO
|--------------------------------------------------------------------------
*/

$routes->get('/carrinho', 'CarrinhoController::index');

/*
|--------------------------------------------------------------------------
| PEDIDOS
|--------------------------------------------------------------------------
*/

$routes->get('/checkout', 'PedidoController::checkout');

$routes->get('/pedido/(:num)', 'PedidoController::visualizar/$1');

/*
|--------------------------------------------------------------------------
| TOTEM
|--------------------------------------------------------------------------
|
| A comunicação com a API do cozinha_restaurante (produtos, categorias,
| pedidos, identificação do totem) acontece via fetch() no navegador.
| Veja public/js/config.js e public/js/totem-status.js.
|
*/