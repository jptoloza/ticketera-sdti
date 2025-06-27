<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('administrator.index',[ 'title' => 'Administrador' ]);
    }
}
