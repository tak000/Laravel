<?php

namespace App\Http\Controllers;
use App\Models\Team;
use App\Models\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Notification;
use App\Notifications\newMember;


class TeamController extends Controller
{
    //* méthode de création d'une team
    public function store(Request $request): RedirectResponse
    {
        //validation
        $validated = Validator::make($request->all(),[
            'name' => 'required|string'
        ]);

        //echec validation check
        if ($validated->fails()) {
            return redirect('/create-team')
                ->withErrors($validated)
                ->withInput();
        }

        //requette creation team
        $team = Team::create([
            'name' => $validated->validated()['name']
        ]);

        //creation de la relation team-user
        $team->users()->attach(Auth::id());

        //redirection vers la page d'acceuil
        return redirect('/dashboard');
    }

    //* méthode d'obtention des team auquel l'utilisateur appartient ainsi que les autres membres
    public function getUserTeams(){
        //requette d'obtention des teams lié a l'utilisateur
        $teams = Auth::user()->teams;
        $teamUsers = [];

        // Assignation des utilisateurs a chaque team
        foreach ($teams as $team) {
            $teamUsers[$team->name] = $team->users()->pluck('name')->toArray();
        }
        
        $data = [
            'teams' => $teams,
            'teamUsers' => $teamUsers
        ];

        //redirection vers page avec les informations
        return view('teams',['data'=>$data]);
    }

    //* méthode d'assignation d'un utilisateur à une team
    public function joinTeam(Request $request): RedirectResponse {
        $user = Auth::user();

        //validation
        $validated = Validator::make($request->all(),[
            'teamid' => 'required|integer',
            'member' => 'required|string',
        ]);

        //echec validation check
        if ($validated->fails()) {
            return redirect('/add-member')
                ->withErrors($validated)
                ->withInput();
        }

        $member = User::where('name', $validated->validated()['member'])->first();
        $team = Team::where('id', $validated->validated()['teamid'])->first();

        if(!$member){
            return redirect()->back()->withErrors(['user404' => "This user does not exist"]);
        }

        if(!$team){
            return redirect()->back()->withErrors(['team404' => "This team does not exist"]);
        }

        if($team->users->contains($user)){
            if(!$team->users->contains($member)){
                $team->users()->attach($member->id);
                $team->users->each(fn($element) => $element->notify(new newMember($member, $team, $user)));
            }else{
                return redirect()->back()->withErrors(['alreadyIn' => "The user is already in that team"]);
            }
        }else{
            return redirect()->back()->withErrors(['belongTeam' => "You cannot invite in a team you're not in"]);
        }

        // redirect back withErrors ....
        return redirect()->back();
    }

    //! ! test avec autocompleted team id
    public function newTeamMemberPage($id)
    {
        return view('add-member', ['id'=>$id]);
    }
}

