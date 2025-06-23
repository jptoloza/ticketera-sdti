<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Helpers\UtilHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Helpers\SessionHelper;

class DashboardController extends Controller
{
    use ResponseTrait;

    /**
     * 
     * 
     */
    public function index(Request $request)
    {
        return redirect()->route('tickets');
    }
}
