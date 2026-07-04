<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoItemModel extends Model
{
    protected $table = 'pedido_itens';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'pedido_id',
        'produto_id',
        'quantidade',
        'valor_unitario'

    ];
}