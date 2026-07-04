<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        return view('auth/login');
    }

    public function autenticar()
    {
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        $usuario = $this->usuarioModel
            ->where('email', $email)
            ->first();

        if (!$usuario) {
            return redirect()->back()->with('erro', 'Usuário ou senha inválidos.');
        }

        if (!$usuario['ativo']) {
            return redirect()->back()->with('erro', 'Usuário bloqueado.');
        }

        if (!password_verify($senha, $usuario['senha'])) {
            return redirect()->back()->with('erro', 'Usuário ou senha inválidos.');
        }

        session()->set([
            'usuario_id' => $usuario['id'],
            'usuario_nome' => $usuario['nome'],
            'usuario_email' => $usuario['email'],
            'usuario_perfil' => $usuario['perfil'],
            'logado' => true
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}