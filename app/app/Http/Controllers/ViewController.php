<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\View\View;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function homepage(): View
    {
        return view('welcome');
    }

    public function dashboard(): View
    {
        return view('dashboard');
    }

    public function addPassword(): View
    {
        return view('add-password');
    }

    public function createTeam(): View
    {
        return view('create-team');
    }


}
