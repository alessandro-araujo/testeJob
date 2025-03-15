<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function login()
    {
        return view('login.index');
    }

    public function authenticate(LoginRequest $request)
    {
        $request->validated();

        // Proteção contra tentativas excessivas
        $key = 'login-attempts:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->with('error', 'Muitas tentativas de login. Tente novamente mais tarde.');
        }

        $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if(!$authenticated){
            // Erro ao conseguir logar no sistema
            return back()->withInput()->with('error', 'E-mail ou Senha inválida');
        }

        $request->session()->regenerate();
        return redirect()->route('dashboard.view');
    }

    public function register()
    {
        return view('login.create');
    }

    public function store(UserRequest $request)
    {
        $request->validated();
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => $request->password,
            ]);
            return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e);
        }
    }

    public function destroy()
    {
        // Destruindo a SESSION
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Deslogado com sucesso!');
    }
}
