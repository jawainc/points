<?php

namespace App\Http\Controllers\Api;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * check login for api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate (Request $request) {

        $users = Role::where('name', 'Mentor')->first()->users;

        $authenticated = false;

        foreach ($users as $user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::guard('api')->login($user);
                $authenticated = true;
                break;
            }
        }

        if ($authenticated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json(['message' => 'Invalid Password'], 422);
        }
    }

    /**
     * logout
     */
    public function logout () {
        Auth::logout();
    }
}