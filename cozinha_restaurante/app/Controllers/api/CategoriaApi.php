<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class CategoriaApi extends BaseController
{
    public function listar()
    {
        $categoriaModel = new CategoriaModel();

        return $this->response->setJSON(
            $categoriaModel->findAll()
        );
    }
}
