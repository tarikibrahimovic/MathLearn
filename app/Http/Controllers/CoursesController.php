<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Lessons;
use Illuminate\Support\Facades\Session;

use function Termwind\render;

class CoursesController extends Controller
{
    //

    public function create()
    {
        return view('courses.create');
    }

    public function show()
    {
        $course = Courses::find(request('id'));
        $user = auth()->user();
        return view('courses.show', compact('course', 'user'));
    }

    public function edit()
    {
        $course = Courses::find(request('id'));
        return view('courses.edit', compact('course'));
    }

    public function update()
    {
        $data = request()->validate([
            'name' => '',
            'description' => '',
            'image' => 'image',
            'fileName' => '',
            'fileDesc' => '',
        ]);
        
        $course = Courses::find(request('id'));

        dd($course->lesson);

        if (auth()->user()->jmbg !== (int)$course->user_id) {
            return redirect('/');
        }
    
            $course->name = $data['name'] ?? $course->name;
            $course->description = $data['description'] ?? $course->description;
            if (request('image')) {
                $imagePath = request('image')->store('uploads', 'public');
                $image_stored = Cloudinary::upload(public_path("storage/{$imagePath}"))->getSecurePath();
                unlink(public_path("storage/{$imagePath}"));
                $course->image = $image_stored;
            }
            $course->save();


        if (request('files') && $data['fileName'] && $data['fileDesc']) {
            foreach (request('files') as $file) {
                $lesson = new Lessons();
                $lesson->name = $data['fileName'];
                $lesson->description = $data['fileDesc'];
                $lesson->course_id = $course->id;
                $lessonPath = $file->store('uploads', 'public');
                $lesson_stored = Cloudinary::upload(public_path("storage/{$lessonPath}"),[
                    'resource_type' => 'auto',
                ])->getSecurePath();
                $lesson->file = $lesson_stored;
                $lesson->save();
            }
            unlink(public_path("storage/{$lessonPath}"));
        }
        
        Session::flash('message', 'Course updated successfully');

        return redirect('/teacher/courses/' . $course->id);
    }

    public function store()
    {
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
            'image' => $image_uploaded,
        ]);

        return redirect('/teacher');
    }
}
