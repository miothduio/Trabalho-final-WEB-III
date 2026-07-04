<?php

namespace App\Controllers;

class PedidoController extends BaseController
{
    public function checkout()
    {
        return view('checkout');
    }

    public function visualizar($id)
    {
        return view('pedido', ['id' => $id]);
    }
}
