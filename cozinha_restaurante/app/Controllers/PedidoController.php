<?php

namespace App\Controllers;

use App\Models\PedidoModel;

class PedidoController extends BaseController
{
    protected $pedidoModel;

    public function __construct()
    {
        helper(['form','url']);

        $this->pedidoModel = new PedidoModel();
    }

    public function index()
    {
        $inicio = $this->request->getGet('inicio');

        $fim = $this->request->getGet('fim');

        $status = $this->request->getGet('status');

        $builder = $this->pedidoModel;

        if(!empty($inicio))
        {
            $builder->where(
                'DATE(data_pedido) >=',
                $inicio
            );
        }

        if(!empty($fim))
        {
            $builder->where(
                'DATE(data_pedido) <=',
                $fim
            );
        }

        if(!empty($status))
        {
            $builder->where(
                'status',
                $status
            );
        }

        $pedidos = $builder
            ->orderBy(
                'data_pedido',
                'DESC'
            )
            ->findAll();

        return view(
            'pedidos/index',
            [

                'pedidos'=>$pedidos,

                'inicio'=>$inicio,

                'fim'=>$fim,

                'status'=>$status

            ]
        );
    }

    public function detalhe($id)
    {
        $pedido = $this->pedidoModel->find($id);

        if(!$pedido)
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $db = \Config\Database::connect();

        $itens = $db
            ->table('pedido_itens pi')
            ->select('
                pi.*,
                produtos.nome
            ')
            ->join(
                'produtos',
                'produtos.id = pi.produto_id'
            )
            ->where(
                'pi.pedido_id',
                $id
            )
            ->get()
            ->getResultArray();

        return view(
            'pedidos/detalhe',
            [

                'pedido'=>$pedido,

                'itens'=>$itens

            ]
        );
    }

    public function finalizar($id)
    {
        $this->pedidoModel->update(

            $id,

            [

                'status'=>'Finalizado',

                'hora_fim'=>date('H:i:s')

            ]

        );

        return redirect()->to('/pedidos');
    }

    public function cancelar($id)
    {
        $this->pedidoModel->update(

            $id,

            [

                'status'=>'Cancelado',

                'hora_fim'=>date('H:i:s')

            ]

        );

        return redirect()->to('/pedidos');
    }
}