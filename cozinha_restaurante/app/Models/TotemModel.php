<?php

namespace App\Models;

use CodeIgniter\Model;

class TotemModel extends Model
{
    protected $table = 'totens';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useAutoIncrement = true;

    protected $useTimestamps = false;

    protected $allowedFields = [

        'chave',

        'token',

        'numero_totem',

        'ip',

        'hostname',

        'descricao',

        'ativo',

        'ativado',

        'online',

        'ultima_conexao'

    ];

    public function listar()
    {
        return $this
            ->orderBy('numero_totem', 'ASC')
            ->findAll();
    }

    /*
    |--------------------------------------------------------------------------
    | Gera uma chave de ativação única
    |--------------------------------------------------------------------------
    */

    public function gerarChave(): string
    {
        do {
            $chave = strtoupper(bin2hex(random_bytes(3)));
        } while ($this->where('chave', $chave)->first());

        return $chave;
    }

    /*
    |--------------------------------------------------------------------------
    | Gera o token secreto de dispositivo (entregue só a quem ativou a chave)
    |--------------------------------------------------------------------------
    */

    public function gerarToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}
