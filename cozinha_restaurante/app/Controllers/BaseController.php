<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Services;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * Helpers carregados automaticamente.
     *
     * @var array
     */
    protected $helpers = [
        'url',
        'form'
     ];

    /**
     * Layout utilizado pelas Views.
     *
     * @var string
     */
    protected $layout = 'layouts/admin';

    /**
     * Dados compartilhados com todas as views.
     *
     * @var array
     */
    protected $viewData = [];

    /**
     * Inicialização do Controller.
     */
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController(
            $request,
            $response,
            $logger
        );

        // Define o layout conforme o perfil do usuário na sessão
        if (session()->has('usuario_perfil')) {
            switch (session('usuario_perfil')) {
                case 'SUPER_ADMIN':
                    $this->layout = 'layouts/admin';
                    break;
                case 'USUARIO':
                    $this->layout = 'layouts/cozinha';
                    break;
                default:
                    $this->layout = 'layouts/admin';
                    break;
            }
        }

        // Armazena no array interno por garantia
        $this->viewData['layout'] = $this->layout;

        // SOLUÇÃO DO PROBLEMA:
        // Compartilha a variável globalmente com a engine de Views do CodeIgniter
        Services::renderer()->setVar('layout', $this->layout);
    }
}