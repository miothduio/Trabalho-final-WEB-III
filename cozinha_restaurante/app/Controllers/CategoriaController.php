<?php

namespace App\Controllers;

use App\Models\CategoriaModel;

class CategoriaController extends BaseController
{
    protected $categoriaModel;

    public function __construct()
    {
        helper(['form', 'url']);

        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $categorias = $this->categoriaModel
            ->select('categorias.*, COUNT(produtos.id) AS total_produtos')
            ->join(
                'produtos',
                'produtos.categoria_id = categorias.id',
                'left'
            )
            ->groupBy('categorias.id')
            ->orderBy('categorias.nome', 'ASC')
            ->findAll();

        return view(
            'categorias/index',
            [
                'categorias' => $categorias
            ]
        );
    }

    public function novo()
    {
        return view('categorias/form');
    }

    public function salvar()
    {
        $this->categoriaModel->save([

            'nome' => $this->request->getPost('nome')

        ]);

        return redirect()->to('/categorias');
    }

    public function editar($id)
    {
        return view(
            'categorias/form',
            [
                'categoria' => $this->categoriaModel->find($id)
            ]
        );
    }

    public function atualizar($id)
    {
        $this->categoriaModel->update($id,[

            'nome' => $this->request->getPost('nome')

        ]);

        return redirect()->to('/categorias');
    }

    public function excluir($id)
    {
        $categoria = $this->categoriaModel->find($id);

        if(!$categoria){

            return redirect()->to('/categorias');

        }

        $db = \Config\Database::connect();

        $produtos = $db
            ->table('produtos')
            ->where('categoria_id',$id)
            ->countAllResults();

        if($produtos > 0){

            return redirect()
                ->to('/categorias')
                ->with(
                    'erro',
                    'Não é possível excluir uma categoria que possui produtos.'
                );

        }

        $this->categoriaModel->delete($id);

        return redirect()
            ->to('/categorias')
            ->with(
                'sucesso',
                'Categoria excluída com sucesso.'
            );
    }

}