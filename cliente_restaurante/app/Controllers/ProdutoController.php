<?php

namespace App\Controllers;

class ProdutoController extends BaseController
{
    public function index()
    {
        return view('produtos');
    }
}
