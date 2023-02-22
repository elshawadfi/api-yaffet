<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class DashboardAuthController extends Controller
{
    public function login(Request $request)
    {
        
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
            $admin = Admin::where('email', $request->email)->first();

            Session::put('admin' ,$admin);

            return redirect(route('admin-index'));
        }

        return back()->with('error', 'Invaild email or password !!');

    }

    public function update_password(UpdatePasswordRequest $request)
    {
        $admin = Admin::findOrFail(Session::get('admin')->id);

        if(Hash::check($request->old_password, $admin->password)){
            $admin->update([
                'password' => Hash::make($request->password),
            ]);

            return back()->with('success', 'Password Updated Successfully.');

        }

        return back()->with('error', 'Sorry something went wrong check your password!!');
    }


    public function update_info(UpdateAdminInfoRequest $request)
    {
        $admin = Admin::find(Session::get('admin')->id);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Information Updated Successfully.');
    }


    public function logout()
    {
        Session::forget('admin');
        
        return redirect(route('login'));
    }




    public function profile()
    {
        $admin = Admin::find(Session::get('admin')->id);

        return view('dashboard.admin-profile', compact('admin'));
    }
}
