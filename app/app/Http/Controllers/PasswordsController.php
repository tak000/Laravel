<?php

namespace App\Http\Controllers;
use App\Models\Password;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PasswordsController extends Controller
{
    //* fonction d'enregistrement de mot de passe lié à un utilisateur
    public function store(Request $request): RedirectResponse
    {

        //validation
        $validated = Validator::make($request->all(),[
            'url' => 'required|url',
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        //echec validation check
        if ($validated->fails()) {
            return redirect('/add-password')
                ->withErrors($validated)
                ->withInput();
        }

        //requette de création du mot de passe
        Password::create([
            'site' => $validated->validated()['url'],
            'login' => $validated->validated()['login'],
            'password' => $validated->validated()['password'],
            'user_id' => Auth::id()
        ]);     
 
        //redirection vers liste de mots de passes
        return redirect('/passwords');
    }

    //* méthode d'obtention des mots de passes d'un utilisateur
    public function getPasswords()
    {
        //requette d'obtention des mots de passes
        $data = Password::where('user_id', Auth::id())->get();

        //redirection vers page avec la liste
        return view('passwords',['data'=>$data]);
    }

    //* redirection vers page de changement d'un mot de passe
    public function passwordChangePage($id)
    {
        // TODO faire un check de securite avec auth::id et user_id du mot de passe
        $data = Password::where('id', $id)->get();

        //redirection vers page de changement avec id
        return view('change-password', ['id'=>$id]);
    }

    //* méthode de modification d'un mot de passe
    public function editPassword(Request $request)
    {
        Password::where('id', $request->id)->first()->update(['password' => $request->password]);

        //redirection vers liste des mots de passes
        return redirect('/passwords');
    }

}

