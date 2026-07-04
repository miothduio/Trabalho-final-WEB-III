<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class PerfilController extends BaseController
{
    public function index()
    {
        $model = new UsuarioModel();

        $usuario = $model->find(session('usuario_id'));

        return view(
            'perfil/index',
            [
                'usuario' => $usuario
            ]
        );
    }

    public function atualizar()
    {
        $model = new UsuarioModel();

        $dados = [

            'nome'  => $this->request->getPost('nome'),

            'email' => $this->request->getPost('email')

        ];

        if ($this->request->getPost('senha') != '') {

            $dados['senha'] = password_hash(

                $this->request->getPost('senha'),

                PASSWORD_DEFAULT

            );

        }

        $model->update(

            session('usuario_id'),

            $dados

        );

        session()->set([

            'usuario_nome' => $dados['nome'],

            'usuario_email' => $dados['email']

        ]);

        return redirect()->back()
            ->with('sucesso', 'Perfil atualizado com sucesso.');
    }
}