<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedidos';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

    'numero_pedido',

    'numero_totem',

    'cliente_nome',

    'cliente_telefone',

    'valor_total',

    'observacoes',

    'status',

    'data_pedido',

    'hora_inicio',

    'hora_fim'


    ];
}