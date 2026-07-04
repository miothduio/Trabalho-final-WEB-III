<?php

namespace App\Controllers;

use App\Models\TotemModel;

class TotemController extends BaseController
{
    protected $totemModel;

    public function __construct()
    {
        $this->totemModel = new TotemModel();
    }

    /*
    |--------------------------------------------------------------------------
    | Listagem
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('totens/index', [

            'title'   => 'Totens',

            'totens'  => $this->totemModel->listar()

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Novo
    |--------------------------------------------------------------------------
    */

    public function novo()
    {
        return view('totens/form', [

            'title' => 'Novo Totem',

            'acao'  => base_url('totens/salvar'),

            'totem' => null

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Salvar
    |--------------------------------------------------------------------------
    |
    | A chave de ativação é gerada automaticamente pelo sistema. É ela que
    | deve ser informada no totem físico (cliente_restaurante) para que ele
    | assuma a identidade deste registro.
    |
    */

    public function salvar()
    {
        $this->totemModel->insert([

            'chave'         => $this->totemModel->gerarChave(),

            'numero_totem' => $this->request->getPost('numero_totem'),

            'hostname'      => $this->request->getPost('hostname'),

            'descricao'     => $this->request->getPost('descricao'),

            'ativo'         => $this->request->getPost('ativo') ? 1 : 0,

            'ativado'       => 0

        ]);

        return redirect()->to('/totens');
    }

    /*
    |--------------------------------------------------------------------------
    | Editar
    |--------------------------------------------------------------------------
    */

    public function editar($id)
    {
        return view('totens/form', [

            'title' => 'Editar Totem',

            'acao'  => base_url('totens/atualizar/'.$id),

            'totem' => $this->totemModel->find($id)

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Atualizar
    |--------------------------------------------------------------------------
    */

    public function atualizar($id)
    {
        $this->totemModel->update($id,[

            'numero_totem' => $this->request->getPost('numero_totem'),

            'hostname'      => $this->request->getPost('hostname'),

            'descricao'     => $this->request->getPost('descricao'),

            'ativo'         => $this->request->getPost('ativo') ? 1 : 0

        ]);

        return redirect()->to('/totens');
    }

    /*
    |--------------------------------------------------------------------------
    | Gerar nova chave
    |--------------------------------------------------------------------------
    |
    | Invalida a chave atual (o totem físico que estava usando ela perde a
    | identidade e volta a pedir ativação) e gera uma nova, marcando o
    | totem como não ativado novamente.
    |
    */

    public function regenerarChave($id)
    {
        $totem = $this->totemModel->find($id);

        if ($totem) {

            $this->totemModel->update($id, [

                'chave'   => $this->totemModel->gerarChave(),

                'token'   => null,

                'ativado' => 0

            ]);

        }

        return redirect()->to('/totens/editar/'.$id);
    }

    /*
    |--------------------------------------------------------------------------
    | Excluir
    |--------------------------------------------------------------------------
    */

    public function excluir($id)
    {
        $this->totemModel->delete($id);

        return redirect()->to('/totens');
    }
}
