<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('admin.adminApproving', compact('users'));
    }

    public function update(Request $request, $id){

        $user = User::find($id);
        $user->approved = 1;
        $user->save();
        Session::flash('approved', 'User approved');
        return redirect()->route('admin.index');
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        Session::flash('deleted', 'User deleted');
        return redirect()->route('admin.index');
    }
}
