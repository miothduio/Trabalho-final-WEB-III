<?php

namespace App\Controllers;

use App\Models\ConsumoModel;
use App\Models\CategoriaModel;

class ConsumoController extends BaseController
{
    public function index()
    {
        $categoria = $this->request->getGet('categoria');
        $inicio = $this->request->getGet('inicio');
        $fim = $this->request->getGet('fim');

        $consumoModel = new ConsumoModel();
        $categoriaModel = new CategoriaModel();

        $produtos = $consumoModel->listar(
            $categoria,
            $inicio,
            $fim
        );

        $totalProdutos = count($produtos);

        $ativos = 0;
        $vendidos = 0;
        $faturamento = 0;

        foreach ($produtos as $produto) {

            if ($produto['ativo']) {

                $ativos++;

            }

            $vendidos += $produto['vendidos'];

            $faturamento += $produto['faturamento'];

        }

        return view('consumo/index', [

            'categorias' => $categoriaModel->findAll(),

            'produtos' => $produtos,

            'categoriaSelecionada' => $categoria,

            'inicio' => $inicio,

            'fim' => $fim,

            'totalProdutos' => $totalProdutos,

            'ativos' => $ativos,

            'vendidos' => $vendidos,

            'faturamentoTotal' => $faturamento

        ]);
    }
}