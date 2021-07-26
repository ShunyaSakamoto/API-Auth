<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login Successful', 'token' => $request->user()->api_token], 200);
        }

        throw ValidationException::withMessages(['email' => 'Try it again because the credentials are incorrect.']);
    }

    public function logout()
    {
        Auth::logout();
        
        return response()->json(['message' => 'You are logged out.'], 200);
    }
}
