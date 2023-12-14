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


class TeamController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = Validator::make($request->all(),[
            'name' => 'required|string'
        ]);

        if ($validated->fails()) {
            return redirect('/create-team')
                ->withErrors($validated)
                ->withInput();
        }

        $team = Team::create([
            'name' => $validated->validated()['name']
        ]);

        $team->users()->attach(Auth::id());

        return redirect('/dashboard');
    }

    public function getUserTeams(){
        $teams = Auth::user()->teams;
        $teamUsers = [];

        // Retrieve users for each team and store them in an array
        foreach ($teams as $team) {
            $teamUsers[$team->name] = $team->users()->pluck('name')->toArray();
        }
        
        $data = [
            'teams' => $teams,
            'teamUsers' => $teamUsers
        ];

       return view('teams',['data'=>$data]);
    }

    public function joinTeam(Request $request): RedirectResponse {
        $user = Auth::user();

        $validated = Validator::make($request->all(),[
            'team' => 'required|string',
            'member' => 'required|string',
        ]);

        if ($validated->fails()) {
            return redirect('/add-member')
                ->withErrors($validated)
                ->withInput();
        }

        $member = User::where('name', $validated->validated()['member'])->first();
        $team = Team::where('name', $validated->validated()['team'])->first();

        if(!$member){
            return redirect()->back()->withErrors(['user404' => "This user does not exist"]);
        }

        if(!$team){
            return redirect()->back()->withErrors(['team404' => "This team does not exist"]);
        }

        if($team->users->contains($user)){
            if(!$team->users->contains($member)){
                $team->users()->attach($member->id);
            }else{
                return redirect()->back()->withErrors(['alreadyIn' => "The user is already in that team"]);
            }
        }else{
            return redirect()->back()->withErrors(['belongTeam' => "You cannot invite in a team you're not in"]);
        }

        // redirect back withErrors ....







    }
}

