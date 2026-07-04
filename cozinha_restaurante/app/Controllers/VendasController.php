<?php

namespace App\Controllers;

use App\Models\VendasModel;

class VendasController extends BaseController
{
    public function index()
    {
        $inicio = $this->request->getGet('inicio');
        $fim = $this->request->getGet('fim');

        $model = new VendasModel();

        $vendas = $model->listar(
            $inicio,
            $fim
        );

        $faturamento = $model->faturamento(
            $inicio,
            $fim
        );

        $totalPedidos = $model->quantidadePedidos(
            $inicio,
            $fim
        );

        $grafico = $model->vendasGrafico(
            $inicio,
            $fim
        );

        $ticketMedio = 0;

        if ($totalPedidos > 0) {

            $ticketMedio =
                $faturamento['total'] / $totalPedidos;

        }

        return view(
            'vendas/index',
            [

                'vendas' => $vendas,

                'grafico' => $grafico,

                'inicio' => $inicio,

                'fim' => $fim,

                'faturamento' =>
                    $faturamento['total'] ?? 0,

                'pedidos' =>
                    $totalPedidos,

                'ticketMedio' =>
                    $ticketMedio

            ]
        );
    }
}