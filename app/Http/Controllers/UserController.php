<?php

namespace App\Http\Controllers;

use App\Models\UsersPassword;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //

    public function show(int $teachers_id){
        $user = User::where('jmbg', $teachers_id)->first();
        return view('teacher.show', compact('user'));
    }

    public function index()
    {
        if(!auth()->user()) {
            return redirect('/login');
        }
        $user = auth()->user();
        return view('user.index', compact('user'));
    }

    public function changeImage(){
        if(!auth()->user()) {
            return redirect('/login');
        }
        $user = auth()->user();
        return view('user.changeImage', compact('user'));
    }

    public function updateImage(){
        if(!auth()->user()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $storedImage = request('image')->store('images', 'public');
        Cloudinary::destroy($user->jmbg);
        $image_uploaded = Cloudinary::upload(public_path("storage/{$storedImage}"), [
            'public_id' => $user->jmbg,
        ])->getSecurePath();
        $user->image = $image_uploaded;
        $user->save();
        Session::flash('message', 'Image updated successfully');
        return redirect('/menu');
    }

    public function changeName(){
        if(!auth()->user()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $user->name = request('name');
        $user->surname = request('surname');
        $user->save();
        Session::flash('message', 'Name and surname updated successfully');
        return redirect('/menu');
    }

    public function changePassword(){
        if(!auth()->user()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $password = Hash::make(request('password'));

        if (UsersPassword::where('user_id', $user->jmbg)->where('password', $password)->count() > 3) {
            Session::flash('error', 'You have already used this password 3 times, please choose another one');
            return redirect('/menu');
        }
        $user->password = $password;
        $user->save();
        UsersPassword::create([
            'user_id' => $user->jmbg,
            'password' => $password,
        ]);
        Session::flash('message', 'Password updated successfully');
        return redirect('/menu');
    }

    public function destroy(){
        if(!auth()->user()) {
            return redirect('/login');
        }
        $user = auth()->user();
        if (Hash::check(request('password'), $user->password)) {
            if($user->type == 'predavac' || $user->type == 'admin'){
                $user->active = 0;
                $user->save();
                UsersPassword::where('user_id', $user->jmbg)->delete();
                auth()->logout();
                Session::flash('message', 'Account deleted successfully');
                return redirect('/login');
            }
            else{
                $user->delete();
                UsersPassword::where('user_id', $user->jmbg)->delete();
                auth()->logout();
                Session::flash('message', 'Account deleted successfully');
                return redirect('/login');
            }
        }
        else{
            Session::flash('error', 'Wrong password');
            return redirect('/menu');
        }
    }
}
