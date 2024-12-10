<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // carrega as notas dos usuários
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        // mostra a view home
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        echo "nova nota";
    }
}
