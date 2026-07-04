<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsumoModel extends Model
{
    protected $table = 'produtos';

    public function listar($categoria = null, $inicio = null, $fim = null)
    {
        $builder = $this->db->table('produtos p');

       $builder->select("
     p.id,
    p.nome,
    p.imagem,
    p.preco,
    p.ativo,
    p.estoque,
    c.nome AS categoria,

    COALESCE(SUM(pi.quantidade),0) AS vendidos,

    COALESCE(
        SUM(pi.quantidade * pi.valor_unitario),
    0) AS faturamento
");

        $builder->join(
            'categorias c',
            'c.id = p.categoria_id',
            'left'
        );

        $builder->join(
            'pedido_itens pi',
            'pi.produto_id = p.id',
            'left'
        );

        $builder->join(
            'pedidos pe',
            'pe.id = pi.pedido_id',
            'left'
        );

        if (!empty($categoria)) {

            $builder->where(
                'p.categoria_id',
                $categoria
            );

        }

        if (!empty($inicio)) {

            $builder->where(
                'DATE(pe.data_pedido) >=',
                $inicio
            );

        }

        if (!empty($fim)) {

            $builder->where(
                'DATE(pe.data_pedido) <=',
                $fim
            );

        }

        $builder->groupBy('p.id');

        $builder->orderBy('p.nome', 'ASC');

        return $builder->get()->getResultArray();
    }
}