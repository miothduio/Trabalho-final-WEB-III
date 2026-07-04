<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'categorias';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'nome'

    ];

    protected $useTimestamps = false;
}