<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| PAINEL DE PEDIDOS
|--------------------------------------------------------------------------
|
| Acesso livre para a equipe do restaurante, sem login. Views magras:
| toda a listagem e as ações (preparar/finalizar/cancelar) acontecem via
| fetch() no navegador, consumindo a API pública do cozinha_restaurante.
|
*/

$routes->get('/', 'PainelController::index');
$routes->get('/pedido/(:num)', 'PainelController::detalhe/$1');
