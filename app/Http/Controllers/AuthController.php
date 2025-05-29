<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // exibe o formulário de login
    public function loginForm()
    {
        return view('auth.login');
    }

    // processa o login 
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Login realizado com sucesso!',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'is_admin' => $user->is_admin,
                    ]
                ]);
            }
            // Para requisições web tradicionais
            session()->flash('success', 'Login realizado com sucesso!');
            return redirect()->route('home');
        }

        if ($request->expectsJson()) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }
        return back()->withErrors(['email' => 'Email ou senha incorretos, tente novamente']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logout realizado com sucesso.']);
        }

        return redirect()->route('login')->with('success', 'Você saiu com sucesso.');
    }

    // exibe o formulário de registro 
    public function create()
    {
        return view('auth.register');
    }

    // salva no banco de dados 
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Usuário cadastrado com sucesso!',
                'user' => $user
            ], 201); // HTTP 201 Created
        }

        return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso! Faça login.');
    }
}
