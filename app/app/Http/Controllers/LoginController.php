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
// use Illuminate\Support\Facades\Crypt;


class LoginController extends Controller
{



    public function store(Request $request): RedirectResponse
    {

        $validated = Validator::make($request->all(),[
            'url' => 'required|url',
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validated->fails()) {
            return redirect('/formulaire')
                ->withErrors($validated)
                ->withInput();
        }

        // Crypt::encryptString()

        Password::create([
            'site' => $validated->validated()['url'],
            'login' => $validated->validated()['login'],
            'password' => $validated->validated()['password'],
            'user_id' => Auth::id()
        ]);



        // Storage::put(Str::uuid().'.json', json_encode($validated->validated()));
        
 
        return redirect('/formulaire');
    }


}
