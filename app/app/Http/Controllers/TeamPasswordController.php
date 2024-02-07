<?php

namespace App\Http\Controllers;
use App\Models\Team;

use App\Models\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

use App\Notifications\newPasswordTeam;

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
        $user = Auth::user();
        $team = Team::where('id', $request->id)->first();

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

        $password->teams()->attach($validated->validated()['id']);

        $team->users->each(fn($element) => $element->notify(new newPasswordTeam($user, $team, $validated->validated()['url'])));
 
        return redirect('/teams');
    }
}
