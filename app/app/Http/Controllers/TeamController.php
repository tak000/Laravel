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



        $team->user()->attach(Auth::id());

        
 
        return redirect('/dashboard');
    }
}

