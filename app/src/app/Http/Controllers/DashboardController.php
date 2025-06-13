<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\UserSession;

class DashboardController extends Controller
{
    //

    public function index(Request $request)
    {   
        return view('dashboard',[
            'title' => 'SDTI: ServiceDesk'
        ]);

    }
}
