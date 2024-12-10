<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // validação de formulário
        $request->validate(
            // regras
            [
                'text_username' => 'required | email',
                'text_password' => 'required | min:6 | max:16'
            ],
            // mensagens de erro
            [
                'text_username.required' => 'O username é obrigatório!',
                'text_username.email' => 'O username deve ser um e-mal válido.',
                'text_password.required' => 'A senha é obrigatória!',
                'text_password.min' => 'A senha deve ter pelo menos :min caracteres.',
                'text_password.max' => 'A senha deve ter no máximo :max caracteres.'
            ]
        );

        // get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // checar se o usuário existe
        $user = User::where('username', $username)->where('deleted_at', NULL)->first();
        // se usuário não existir
        if(!$user){
            // redireciona-> pra trás-> guardando o input-> com um erro específico
            return redirect()->back()->withInput()->with('loginError', 'Username ou password incorretos.');
        }

        // checar se a password existe
        if(!password_verify($password, $user->password)){
            return redirect()->back()->withInput()->with('loginError', 'Username ou password incorretos.');
        }

        // atualiza o último login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // usuário logado
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        // redirecionar para home
        return redirect()->to('/');
    }

    public function logout()
    {
        // logout da aplicação
        session()->forget('user');
        return redirect()->to('/login');
    }
}
