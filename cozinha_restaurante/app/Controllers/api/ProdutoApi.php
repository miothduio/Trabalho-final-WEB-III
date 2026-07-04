<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;

class ProdutoApi extends BaseController
{
    public function listar()
    {
        $produtoModel = new ProdutoModel();

        $produtos = $produtoModel
            ->where('ativo', 1)
            ->findAll();

        return $this->response->setJSON($produtos);
    }

    public function categoria($id)
    {
        $produtoModel = new ProdutoModel();

        $produtos = $produtoModel
            ->where('categoria_id', $id)
            ->where('ativo', 1)
            ->findAll();

        return $this->response->setJSON($produtos);
    }
}
