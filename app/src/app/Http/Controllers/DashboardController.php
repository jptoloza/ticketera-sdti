<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function Index(Request $request)
    {
        
        return view('dashboard',[
            'title' => 'SDTI: ServiceDesk'
        ]);

    }
}
