<?php

namespace App\Http\Controllers;
use App\Models\Password;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;


class GetPasswordsController extends Controller
{



    public function getPasswords()
    {
        $data = Password::where('user_id', Auth::id())->get();
         // dd(Crypt::decryptString($data[5]->password));


        return view('passwords',['data'=>$data]);
    }


}

