<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    // Lista todos os usuários
    public function index()
    {
        $dados['usuarios'] = $this->usuarioModel
            ->orderBy('nome', 'ASC')
            ->findAll();

        return view('usuarios/index', $dados);
    }

    // Exibe formulário de cadastro
    public function novo()
    {
        return view('usuarios/form');
    }

    // Salva usuário
    public function salvar()
    {
        $senha = password_hash(
            $this->request->getPost('senha'),
            PASSWORD_DEFAULT
        );

        $this->usuarioModel->insert([
            'nome'    => $this->request->getPost('nome'),
            'email'   => $this->request->getPost('email'),
            'senha'   => $senha,
            'perfil'  => $this->request->getPost('perfil'),
            'ativo'   => 1
        ]);

        return redirect()->to('/usuarios');
    }

    // Formulário de edição
    public function editar($id)
    {
        $dados['usuario'] = $this->usuarioModel->find($id);

        return view('usuarios/form', $dados);
    }

    // Atualiza usuário
    public function atualizar($id)
    {
        $dados = [

            'nome'   => $this->request->getPost('nome'),

            'email'  => $this->request->getPost('email'),

            'perfil' => $this->request->getPost('perfil')

        ];

        if (!empty($this->request->getPost('senha'))) {

            $dados['senha'] = password_hash(
                $this->request->getPost('senha'),
                PASSWORD_DEFAULT
            );
        }

        $this->usuarioModel->update($id, $dados);

        return redirect()->to('/usuarios');
    }

    // Bloquear
    public function bloquear($id)
    {
        $this->usuarioModel->update($id, [
            'ativo' => 0
        ]);

        return redirect()->to('/usuarios');
    }

    // Desbloquear
    public function desbloquear($id)
    {
        $this->usuarioModel->update($id, [
            'ativo' => 1
        ]);

        return redirect()->to('/usuarios');
    }
}