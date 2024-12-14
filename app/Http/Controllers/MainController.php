<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // carrega as notas dos usuários
        $id = session('user.id');
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();

        // mostra a view home
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        // mostra uma nova nota na view
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {

        // validação da nota
        $request->validate(
            // regras
            [
                'text_title' => 'required |  min:3 | max:200',
                'text_note' => 'required | min:3 | max:3000'
            ],
            // mensagens de erro
            [
                'text_title.required' => 'O título é obrigatório!',
                'text_title.min' => 'O título deve ter pelo menos :min caracteres',
                'text_title.max' => ' título deve ter pelo menos :max caracteres',
                'text_note.required' => 'A nota é obrigatória',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
                'text_note.max' => 'A nota deve ter pelo menos :max caracteres'
            ]
        );

        // pegar id do usuário
        $id = session('user.id');

        // criar nova nota
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // redirecionar para home
        return redirect()->route('home');

    }

    public function editNote($id)
    {
        // $id = $this->decrypt($id);
        $id = Operations::decrypt($id);

        if($id === null){
            return redirect()->route('home');
        }

        // carregar nota
        $note = Note::find($id);

        // mostrar edição da view note
        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {

        // validação do request
        $request->validate(
            // regras
            [
                'text_title' => 'required |  min:3 | max:200',
                'text_note' => 'required | min:3 | max:3000'
            ],
            // mensagens de erro
            [
                'text_title.required' => 'O título é obrigatório!',
                'text_title.min' => 'O título deve ter pelo menos :min caracteres',
                'text_title.max' => ' título deve ter pelo menos :max caracteres',
                'text_note.required' => 'A nota é obrigatória',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
                'text_note.max' => 'A nota deve ter pelo menos :max caracteres'
            ]
        );

        // verificar se note_ir existe
        if($request->note_id == null) {
            return redirect()->route('home');
        }

        // decriptação do user.id
        $id = Operations::decrypt($request->note_id);

        if($id === null){
            return redirect()->route('home');
        }

        // carregar nota
        $note = Note::find($id);

        // atualizar nota
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // redirecionar para home
        return redirect()->route('home');
    }

    public function deleteNote($id)
    {
        // $id = $this->decrypt($id);
        $id = Operations::decrypt($id);

        if($id === null){
            return redirect()->route('home');
        }

        // carrega a nota
        $note = Note::find($id);

        // mostra a confirmação da nota a ser deletada
        return view('delete_note', ['note' => $note]);

    }

    public function deleteNoteConfirm($id)
    {
        // verifica se o $id está encripitado
        $id = Operations::decrypt($id);

        if($id === null){
            return redirect()->route('home');
        }

        // carrega a nota
        $note = Note::find($id);

        // 1. hard delete
        // $note->delete();

        // 2. soft delete
        // $note->deleted_at = date('Y/m/d H:i:s');
        // $note->save();

        // 3. soft delete (propriedade SoftDelete no Model)
        // $note->delete();

        // 4. hard delete (propriedade SoftDelete no Model)
        $note->forceDelete();

        // redireciona
        return redirect()->route('home');
    }
}
