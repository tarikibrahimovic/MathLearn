<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CoursesUser;

class FollowsController extends Controller
{
    //

    public function store(int $course_id){
        if (auth()->guest()) {
            return redirect()->route('login');
        }

        $user = User::find(auth()->user()->jmbg);

        CoursesUser::create([
            'user_jmbg' => $user->jmbg,
            'courses_id' => $course_id
        ]);
        return redirect()->back()->with('message', 'You are now following this course');
    }

    public function destroy(int $course_id){
        if (auth()->guest()) {
            return redirect()->route('login');
        }

        $user = User::find(auth()->user()->jmbg);

        $follows = CoursesUser::where('user_jmbg', $user->jmbg)->where('courses_id', $course_id)->first();
        $follows->delete();
        return redirect()->back()->with('message', 'You are no longer following this course');
    }
}
