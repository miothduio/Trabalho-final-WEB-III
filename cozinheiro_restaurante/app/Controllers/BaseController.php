<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

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
    }
}
