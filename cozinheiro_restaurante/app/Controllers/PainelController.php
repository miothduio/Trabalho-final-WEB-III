<?php

namespace App\Controllers;

class PainelController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Painel de Pedidos da Cozinha
    |--------------------------------------------------------------------------
    |
    | Este controller apenas entrega a view. Toda a listagem de pedidos e
    | as ações (preparar/finalizar/cancelar) acontecem via fetch() no
    | navegador, consumindo a API protegida do cozinha_restaurante.
    |
    */

    public function index()
    {
        return view('painel/index');
    }

    public function detalhe($id)
    {
        return view('painel/detalhe', ['id' => $id]);
    }
}
