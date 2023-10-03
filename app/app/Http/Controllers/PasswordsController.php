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
        
 
        return redirect('/passwords');
    }


    public function getPasswords()
    {
        $data = Password::where('user_id', Auth::id())->get();
         // dd(Crypt::decryptString($data[5]->password));

        return view('passwords',['data'=>$data]);
    }

    public function passwordChangePage($id)
    {
        // TODO faire un check de securite avec auth::id et user_id du mot de passe
        $data = Password::where('id', $id)->get();
        return view('change-password', ['id'=>$id]);
    }

    public function editPassword(Request $request)
    {
        Password::where('id', $request->id)->first()->update(['password' => $request->password]);
        return redirect('/passwords');
    }

}

