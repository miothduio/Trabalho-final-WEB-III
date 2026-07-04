<?php

namespace App\Models;

use CodeIgniter\Model;

class VendasModel extends Model
{
    protected $table = 'pedidos';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useAutoIncrement = true;

    protected $allowedFields = [

        'numero_pedido',

        'cliente_nome',

        'cliente_telefone',

        'valor_total',

        'observacoes',

        'status',

        'data_pedido',

        'hora_inicio',

        'hora_fim'

    ];

    protected $useTimestamps = false;

    public function listar($inicio = null, $fim = null)
    {
        $builder = $this->builder();

        if (!empty($inicio)) {

            $builder->where(
                'DATE(data_pedido) >=',
                $inicio
            );

        }

        if (!empty($fim)) {

            $builder->where(
                'DATE(data_pedido) <=',
                $fim
            );

        }

        $builder->orderBy(
            'data_pedido',
            'DESC'
        );

        return $builder
            ->get()
            ->getResultArray();
    }

    public function faturamento($inicio = null, $fim = null)
    {
        $builder = $this->builder();

        $builder->selectSum(
            'valor_total',
            'total'
        );

        if (!empty($inicio)) {

            $builder->where(
                'DATE(data_pedido) >=',
                $inicio
            );

        }

        if (!empty($fim)) {

            $builder->where(
                'DATE(data_pedido) <=',
                $fim
            );

        }

        return $builder
            ->get()
            ->getRowArray();
    }

    public function quantidadePedidos($inicio = null, $fim = null)
    {
        $builder = $this->builder();

        if (!empty($inicio)) {

            $builder->where(
                'DATE(data_pedido) >=',
                $inicio
            );

        }

        if (!empty($fim)) {

            $builder->where(
                'DATE(data_pedido) <=',
                $fim
            );

        }

        return $builder->countAllResults();
    }

    public function vendasGrafico($inicio = null, $fim = null)
    {
        $builder = $this->builder();

        $builder->select("
            DATE(data_pedido) as dia,
            SUM(valor_total) as total
        ");

        if (!empty($inicio)) {

            $builder->where(
                'DATE(data_pedido) >=',
                $inicio
            );

        }

        if (!empty($fim)) {

            $builder->where(
                'DATE(data_pedido) <=',
                $fim
            );

        }

        $builder->groupBy(
            'DATE(data_pedido)'
        );

        $builder->orderBy(
            'DATE(data_pedido)',
            'ASC'
        );

        return $builder
            ->get()
            ->getResultArray();
    }
}