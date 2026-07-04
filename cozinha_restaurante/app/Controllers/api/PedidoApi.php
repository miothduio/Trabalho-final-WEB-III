<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\PedidoItemModel;
use App\Models\ProdutoModel;

class PedidoApi extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Criar Pedido
    |--------------------------------------------------------------------------
    |
    | Usado pelo totem (cliente_restaurante). Rota pública.
    |
    */

    public function salvar()
    {
        try {

            $dados = $this->request->getJSON();

            if (!$dados || empty($dados->itens)) {

                return $this->response->setStatusCode(400)->setJSON([
                    'status' => false,
                    'erro'   => 'Dados inválidos.'
                ]);
            }

            $pedidoModel  = new PedidoModel();
            $itemModel    = new PedidoItemModel();
            $produtoModel = new ProdutoModel();

            $pedidoId = $pedidoModel->insert([

                'numero_totem'     => $dados->numero_totem ?? 0,
                'cliente_nome'     => $dados->nome,
                'cliente_telefone' => $dados->telefone ?? '',
                'valor_total'      => $dados->valor_total,
                'status'           => 'PENDENTE',
                'data_pedido'      => date('Y-m-d H:i:s')

            ]);

            // Número amigável do pedido (mesmo valor exibido na cozinha e na confirmação: #00001)
            $pedidoModel->update($pedidoId, [
                'numero_pedido' => str_pad($pedidoId, 5, '0', STR_PAD_LEFT)
            ]);

            foreach ($dados->itens as $item) {

                $produto = $produtoModel->find($item->id);

                if (!$produto) {
                    throw new \Exception("Produto não encontrado.");
                }

                if ($produto['estoque'] < $item->quantidade) {
                    throw new \Exception("Estoque insuficiente para o produto: " . $produto['nome']);
                }

                $itemModel->insert([

                    'pedido_id'      => $pedidoId,
                    'produto_id'     => $item->id,
                    'quantidade'     => $item->quantidade,
                    'valor_unitario' => $item->preco,
                    'observacao'     => $item->observacao ?? null

                ]);

                $produtoModel->update($item->id, [
                    'estoque' => $produto['estoque'] - $item->quantidade
                ]);
            }

            return $this->response->setJSON([
                'status' => true,
                'pedido' => $pedidoId
            ]);

        } catch (\Throwable $e) {

            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'erro'   => $e->getMessage()
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Listar Pedidos
    |--------------------------------------------------------------------------
    |
    | Usado pelo painel do cozinheiro_restaurante. Rota pública (o painel
    | de pedidos não exige login).
    |
    */

    public function listar()
    {
        $pedidoModel = new PedidoModel();

        $pedidos = $pedidoModel
            ->select('pedidos.*, (SELECT SUM(quantidade) FROM pedido_itens WHERE pedido_itens.pedido_id = pedidos.id) as total_itens')
            ->orderBy('data_pedido', 'DESC')
            ->findAll();

        return $this->response->setJSON($pedidos);
    }

    /*
    |--------------------------------------------------------------------------
    | Detalhe do Pedido
    |--------------------------------------------------------------------------
    |
    | Usado pelo totem (confirmação do pedido) e pelo cozinheiro (comanda).
    | Rota pública: não expõe dados sensíveis.
    |
    */

    public function detalhe($id)
    {
        $pedidoModel = new PedidoModel();
        $itemModel   = new PedidoItemModel();

        $pedido = $pedidoModel->find($id);

        if (!$pedido) {

            return $this->response->setStatusCode(404)->setJSON([
                'status'   => false,
                'mensagem' => 'Pedido não encontrado.'
            ]);
        }

        $itens = $itemModel
            ->select('pedido_itens.*, produtos.nome')
            ->join('produtos', 'produtos.id = pedido_itens.produto_id')
            ->where('pedido_id', $id)
            ->findAll();

        return $this->response->setJSON([
            'status' => true,
            'pedido' => $pedido,
            'itens'  => $itens
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Iniciar Preparo / Finalizar / Cancelar
    |--------------------------------------------------------------------------
    |
    | Usado pelo painel do cozinheiro_restaurante. Rotas públicas.
    |
    */

    public function preparar($id)
    {
        return $this->mudarStatus($id, 'EM_PREPARO', 'hora_inicio');
    }

    public function finalizar($id)
    {
        return $this->mudarStatus($id, 'FINALIZADO', 'hora_fim');
    }

    public function cancelar($id)
    {
        return $this->mudarStatus($id, 'CANCELADO', 'hora_fim');
    }

    private function mudarStatus($id, string $status, string $campoHora)
    {
        $pedidoModel = new PedidoModel();

        $pedido = $pedidoModel->find($id);

        if (!$pedido) {

            return $this->response->setStatusCode(404)->setJSON([
                'status'   => false,
                'mensagem' => 'Pedido não encontrado.'
            ]);
        }

        $dadosAtualizar = ['status' => $status];

        if (empty($pedido[$campoHora])) {
            $dadosAtualizar[$campoHora] = date('Y-m-d H:i:s');
        }

        $pedidoModel->update($id, $dadosAtualizar);

        return $this->response->setJSON([
            'status' => true,
            'pedido' => $pedidoModel->find($id)
        ]);
    }
}
