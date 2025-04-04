<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class AuthController extends Controller
{
    // Exibe o formulário de login
    public function loginForm()
    {
        return view('auth.login');
    }

    // Processa o login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('home'); // Redireciona para a página inicial
        }

        return back()->withErrors(['email' => 'Email ou senha Inocrretos']);
    }

    // Faz logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Você saiu com sucesso.');
    }

    //form de registro de usuário
    public function create()
    {
        return view('auth.register');
    }

    // salva no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Senha criptografada
        ]);

        return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso! Faça login.');
    }
}