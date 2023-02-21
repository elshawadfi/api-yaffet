<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardAuthController extends Controller
{
    public function login(Request $request)
    {
        
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
            $admin = Admin::where('email', $request->email)->first();

            Session::put(['admin' => $admin]);

            return redirect(route('admin-index'));
        }

        return back()->with('error', 'Invaild email or password !!');

    }

    public function logout()
    {
        Session::forget('admin');
        
        return redirect(route('login'));
    }

    public function profile()
    {
        return view('dashboard.admin-profile');
    }
}
