<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{

    /**
     * show login form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login () {
        return view('admin.login.login');
    }

    /**
     * check and make login
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authLogin (Request $request) {

        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $logged_in = false;

        $user = User::where('email', $request->email)->first();
        if ($user && $user->isAdmin()) {
            if (Hash::check($request->password, $user->password)) {
                if ($request->has('remember')) {
                    Auth::guard('web')->login($user, true);
                } else {
                    Auth::guard('web')->login($user);
                }
                $logged_in = true;
            }
        }


        if ($logged_in) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('admin.login')->with('error', 'Invalid email or password');
        }

    }

    /**
     * logout admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout () {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
