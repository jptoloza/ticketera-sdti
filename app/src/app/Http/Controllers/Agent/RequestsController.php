<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestsController extends Controller
{
    //

    public function Index(Request $request)
    {
        echo "Agent";
    }

    public function Show(Request $request, $id = null)
    {
         return view('agent/request',[
            'title' => 'SDTI: ServiceDesk'
        ]);

    }


}
