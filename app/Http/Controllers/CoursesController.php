<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CoursesController extends Controller
{
    //

    public function create()
    {
        return view('courses.create');
    }

    public function index(){
        return view('courses.index');
    }

    public function store(){
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image',
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image_uploaded = Cloudinary::upload(public_path("storage/{$imagePath}"))->getSecurePath();
            //remove image from local storage
            unlink(public_path("storage/{$imagePath}"));

        auth()->user()->courses()->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $imagePath,
        ]);

        return redirect('/teacher');
    }
}
