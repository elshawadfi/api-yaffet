<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Metal;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $metals = Metal::latest()->take(3)->get();
    
        
        return view('dashboard.index', compact('metals'));
    }
}
