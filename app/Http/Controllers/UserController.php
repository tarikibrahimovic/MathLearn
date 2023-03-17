<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function index()
    {
        if(!auth()->user()) {
            return redirect('/login');
        }
        $user = auth()->user();
        return view('user.index', compact('user'));
    }
}
