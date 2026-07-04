<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

$routes->get('/', 'AuthController::index');
$routes->post('/login', 'AuthController::autenticar');

/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
|
| Rotas utilizadas pelo cliente_restaurante
|
*/

$routes->group('api', function ($routes) {

    /*
    |--------------------------------------------------------------------------
    | Totens
    |--------------------------------------------------------------------------
    */

    // Ativa o totem consumindo a chave (só funciona uma vez por chave)
    $routes->post(
        'totem/ativar',
        'Api\TotemApi::ativar'
    );

    // Identifica o totem pelo token recebido na ativação
    $routes->get(
        'totem/identificar',
        'Api\TotemApi::identificar'
    );

    // Heartbeat (mantém o totem online)
    $routes->post(
        'totem/heartbeat',
        'Api\TotemApi::heartbeat'
    );

    // Atualiza os totens offline
    $routes->get(
        'totem/offline',
        'Api\TotemApi::atualizarOffline'
    );

    /*
    |--------------------------------------------------------------------------
    | Categorias e Produtos (usado pelo cliente_restaurante)
    |--------------------------------------------------------------------------
    */

    $routes->get('categorias', 'Api\CategoriaApi::listar');
    $routes->get('produtos', 'Api\ProdutoApi::listar');
    $routes->get('produtos/categoria/(:num)', 'Api\ProdutoApi::categoria/$1');

    /*
    |--------------------------------------------------------------------------
    | Pedidos (usado pelo cliente_restaurante e pelo cozinheiro_restaurante)
    |--------------------------------------------------------------------------
    |
    | salvar: cliente_restaurante (totem) cria o pedido.
    | detalhe: cliente_restaurante (confirmação) e cozinheiro_restaurante (comanda).
    | listar/preparar/finalizar/cancelar: cozinheiro_restaurante (painel da cozinha).
    |
    | Sem autenticação: o painel do cozinheiro_restaurante é de acesso livre
    | para a equipe do restaurante, sem login.
    |
    */

    $routes->post('pedidos', 'Api\PedidoApi::salvar');
    $routes->get('pedidos', 'Api\PedidoApi::listar');
    $routes->get('pedidos/(:num)', 'Api\PedidoApi::detalhe/$1');
    $routes->post('pedidos/(:num)/preparar', 'Api\PedidoApi::preparar/$1');
    $routes->post('pedidos/(:num)/finalizar', 'Api\PedidoApi::finalizar/$1');
    $routes->post('pedidos/(:num)/cancelar', 'Api\PedidoApi::cancelar/$1');

});

/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

$routes->group('', ['filter' => 'auth'], function ($routes) {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    $routes->get('/dashboard', 'DashboardController::index');

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    $routes->get('/logout', 'AuthController::logout');

    /*
    |--------------------------------------------------------------------------
    | Perfil
    |--------------------------------------------------------------------------
    */

    $routes->get('/perfil', 'PerfilController::index');
    $routes->post('/perfil', 'PerfilController::atualizar');

    /*
    |--------------------------------------------------------------------------
    | Painel de Consumo
    |--------------------------------------------------------------------------
    */

    $routes->get(
        '/consumo',
        'ConsumoController::index'
    );

    /*
    |--------------------------------------------------------------------------
    | Painel de Vendas
    |--------------------------------------------------------------------------
    */

    $routes->get(
        '/vendas',
        'VendasController::index'
    );

});

/*
|--------------------------------------------------------------------------
| ROTAS SOMENTE SUPER ADMIN
|--------------------------------------------------------------------------
*/

$routes->group('', ['filter' => 'admin'], function ($routes) {

    /*
    |--------------------------------------------------------------------------
    | Usuários
    |--------------------------------------------------------------------------
    */

    $routes->get(
        '/usuarios',
        'UsuarioController::index'
    );

    $routes->get(
        '/usuarios/novo',
        'UsuarioController::novo'
    );

    $routes->post(
        '/usuarios/salvar',
        'UsuarioController::salvar'
    );

    $routes->get(
        '/usuarios/editar/(:num)',
        'UsuarioController::editar/$1'
    );

    $routes->post(
        '/usuarios/atualizar/(:num)',
        'UsuarioController::atualizar/$1'
    );

    $routes->get(
        '/usuarios/bloquear/(:num)',
        'UsuarioController::bloquear/$1'
    );

    $routes->get(
        '/usuarios/desbloquear/(:num)',
        'UsuarioController::desbloquear/$1'
    );

    /*
    |--------------------------------------------------------------------------
    | Categorias
    |--------------------------------------------------------------------------
    */

    $routes->get(
        '/categorias',
        'CategoriaController::index'
    );

    $routes->get(
        '/categorias/novo',
        'CategoriaController::novo'
    );

    $routes->post(
        '/categorias/salvar',
        'CategoriaController::salvar'
    );

    $routes->get(
        '/categorias/editar/(:num)',
        'CategoriaController::editar/$1'
    );

    $routes->post(
        '/categorias/atualizar/(:num)',
        'CategoriaController::atualizar/$1'
    );

    $routes->get(
        '/categorias/excluir/(:num)',
        'CategoriaController::excluir/$1'
    );

    /*
    |--------------------------------------------------------------------------
    | Produtos
    |--------------------------------------------------------------------------
    */

    $routes->get(
        '/produtos',
        'ProdutoController::index'
    );

    $routes->get(
        '/produtos/novo',
        'ProdutoController::novo'
    );

    $routes->post(
        '/produtos/salvar',
        'ProdutoController::salvar'
    );

    $routes->get(
        '/produtos/editar/(:num)',
        'ProdutoController::editar/$1'
    );

    $routes->post(
        '/produtos/atualizar/(:num)',
        'ProdutoController::atualizar/$1'
    );

    $routes->get(
        '/produtos/excluir/(:num)',
        'ProdutoController::excluir/$1'
    );

    /*
    |--------------------------------------------------------------------------
    | Totens
    |--------------------------------------------------------------------------
    */

    $routes->get(
        '/totens',
        'TotemController::index'
    );

    $routes->get(
        '/totens/novo',
        'TotemController::novo'
    );

    $routes->post(
        '/totens/salvar',
        'TotemController::salvar'
    );

    $routes->get(
        '/totens/editar/(:num)',
        'TotemController::editar/$1'
    );

    $routes->post(
        '/totens/atualizar/(:num)',
        'TotemController::atualizar/$1'
    );

    $routes->get(
        '/totens/excluir/(:num)',
        'TotemController::excluir/$1'
    );

    $routes->get(
        '/totens/chave/(:num)',
        'TotemController::regenerarChave/$1'
    );

});