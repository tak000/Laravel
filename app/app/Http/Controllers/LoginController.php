<?php

namespace App\Http\Controllers;
use App\Models\Password;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{



    public function store(Request $request): RedirectResponse
    {

        $validated = Validator::make($request->all(),[
            'url' => 'required|url',
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validated->fails()) {
            return redirect('/formulaire')
                ->withErrors($validated)
                ->withInput();
        }



        Password::create([
            'site' => $validated->validated()['url'],
            'login' => $validated->validated()['email'],
            'password' => $validated->validated()['password'],
            'user_id' => Auth::id()
        ]);



        // Storage::put(Str::uuid().'.json', json_encode($validated->validated()));
        
 
        return redirect('/formulaire');
    }


}
