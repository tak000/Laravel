<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class LoginController extends Controller
{



    public function store(Request $request): RedirectResponse
    {

        $validated = Validator::make($request->all(),[
            'url' => 'required|url',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validated->fails()) {
            return redirect('/formulaire')
                ->withErrors($validated)
                ->withInput();
        }

 


        Storage::put(Str::uuid().'.json', json_encode($validated->validated()));
        
 
        return redirect('/formulaire');
    }


}
