<?php

namespace App\Http\Controllers;

use App\Models\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class TeamPasswordController extends Controller
{
    //* redirection vers la page d'ajout d'un mot de passe à une team
    public function newPasswordPage($id)
    {
        return view('add-team-password', ['id'=>$id]);
    }

    //* méthode de création d'un mot de passe assigné à une team
    public function createTeamPassword(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id' => 'required|integer',
            'url' => 'required|url',
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validated->fails()) {
            return redirect('/add-password')
                ->withErrors($validated)
                ->withInput();
        }


        $password = Password::create([
            'site' => $validated->validated()['url'],
            'login' => $validated->validated()['login'],
            'password' => $validated->validated()['password'],
            'user_id' => Auth::id()
        ]);

        $password->teams()->attach($request->id);
 
        return redirect('/teams');
    }
}
