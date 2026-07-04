<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table = 'produtos';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useAutoIncrement = true;

    protected $allowedFields = [

        'categoria_id',

        'nome',

        'descricao',

        'preco',

        'imagem',

        'destaque',

        'ativo',

        'estoque',

        'tempo_preparo'

    ];

    protected $useTimestamps = false;
}