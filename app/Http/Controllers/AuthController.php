<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException; // Importar para erros de validação

class AuthController extends Controller
{
    // Exibe o formulário de login (que montará o Vue component)
    public function loginForm() // Mantém para servir a view Blade
    {
        return view('auth.login');
    }

    // Processa o login (agora adaptado para web e API)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($request->expectsJson()) { // Se a requisição espera JSON (Vue/Axios)
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

    // Faz logout (este já funciona bem para web, para API seria um endpoint separado)
    public function logout(Request $request) // Mantém para web
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Se for uma chamada API, pode retornar JSON
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logout realizado com sucesso.']);
        }

        return redirect()->route('login')->with('success', 'Você saiu com sucesso.');
    }

    // Exibe o formulário de registro (que montará o Vue component)
    public function create() // Mantém para servir a view Blade
    {
        return view('auth.register');
    }

    // Salva no banco de dados (agora adaptado para web e API)
    public function store(Request $request)
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

        if ($request->expectsJson()) { // Se a requisição espera JSON (Vue/Axios)
            return response()->json([
                'message' => 'Usuário cadastrado com sucesso!',
                'user' => $user
            ], 201); // HTTP 201 Created
        }

        // Para requisições web tradicionais
        return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso! Faça login.');
    }
}