<?php

namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\UsuarioModel;
use App\Models\ProdutoModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $pedidoModel = new PedidoModel();

        $produtoModel = new ProdutoModel();

        $usuarioModel = new UsuarioModel();

        $dados = [

            'pedidos' => $pedidoModel->countAll(),

            'produtos' => $produtoModel->countAll(),

            'usuarios' => $usuarioModel->countAll(),

            'faturamento' => $pedidoModel
                ->selectSum('valor_total')
                ->first()['valor_total'] ?? 0

        ];

        return view(
            'dashboard/index',
            $dados
        );
    }
}