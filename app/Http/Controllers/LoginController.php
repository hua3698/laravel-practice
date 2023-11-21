<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; //引入user model
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function createAccount(request $request) {
        echo 'aaaaaaaaa';
    }

    public function signup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => password_hash($validated['password'], PASSWORD_DEFAULT ),
        ]);

        $user->save();
        return response($user, 201);
        // return redirect()->back();
        // return redirect()->route('login');
    }

    public function signIn(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        if(!Auth::attempt($validateData)) {
            return response('登入失敗',401);
        }
        else {
            session(['username' => $request->name]);
        }

        $user = $request->user();
        return $user;
    }

    public function logout()
    {
        session()->forget('username');
        return redirect('/');
    }
}
