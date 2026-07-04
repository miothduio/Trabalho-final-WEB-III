<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use App\Models\CategoriaModel;

class ProdutoController extends BaseController
{
    protected $produtoModel;
    protected $categoriaModel;

    public function __construct()
    {
        helper(['form', 'url']);

        $this->produtoModel = new ProdutoModel();

        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $produtos = $this->produtoModel
            ->select('produtos.*, categorias.nome as categoria')
            ->join('categorias', 'categorias.id = produtos.categoria_id')
            ->findAll();

        return view('produtos/index', [

            'produtos' => $produtos

        ]);
    }

    public function novo()
    {
        return view('produtos/form', [

            'categorias' => $this->categoriaModel->findAll()

        ]);
    }

    public function salvar()
    {
        $imagem = '';

        $arquivo = $this->request->getFile('imagem');

        if ($arquivo && $arquivo->isValid()) {

            $novoNome = $arquivo->getRandomName();

            $arquivo->move(

                ROOTPATH.'public/uploads/produtos',

                $novoNome

            );

            $imagem = 'uploads/produtos/'.$novoNome;
        }

        $this->produtoModel->save([

            'categoria_id' => $this->request->getPost('categoria'),

            'nome' => $this->request->getPost('nome'),

            'descricao' => $this->request->getPost('descricao'),

            'preco' => $this->request->getPost('preco'),

            'estoque' => $this->request->getPost('estoque'),

            'tempo_preparo' => $this->request->getPost('tempo_preparo'),

            'ativo' => $this->request->getPost('ativo'),

            'destaque' => $this->request->getPost('destaque'),

            'imagem' => $imagem

        ]);

        return redirect()->to('/produtos');
    }

    public function editar($id)
    {
        return view('produtos/form',[

            'produto'=>$this->produtoModel->find($id),

            'categorias'=>$this->categoriaModel->findAll()

        ]);
    }

    public function atualizar($id)
    {
        $dados=[

            'categoria_id'=>$this->request->getPost('categoria'),

            'nome'=>$this->request->getPost('nome'),

            'descricao'=>$this->request->getPost('descricao'),

            'preco'=>$this->request->getPost('preco'),

            'estoque'=>$this->request->getPost('estoque'),

            'tempo_preparo'=>$this->request->getPost('tempo_preparo'),

            'ativo'=>$this->request->getPost('ativo'),

            'destaque'=>$this->request->getPost('destaque')

        ];

        $arquivo=$this->request->getFile('imagem');

        if($arquivo && $arquivo->isValid()){

            $novoNome=$arquivo->getRandomName();

            $arquivo->move(

                ROOTPATH.'public/uploads/produtos',

                $novoNome

            );

            $dados['imagem']='uploads/produtos/'.$novoNome;

        }

        $this->produtoModel->update(

            $id,

            $dados

        );

        return redirect()->to('/produtos');
    }

    public function excluir($id)
    {
        $this->produtoModel->delete($id);

        return redirect()->to('/produtos');
    }
}