<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\CoursesUser;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Lessons;
use App\Models\LessonsUser;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use function Termwind\render;

class CoursesController extends Controller
{
    //

    public function create()
    {
        return view('courses.create');
    }

    public function index()
    {
        $courses = Courses::all();
        return view('courses', compact('courses'));
    }

    public function search(){
        if(!request('search')){
            return redirect('/courses');
        }
        $courses = Courses::where('name', 'like', '%' . request('search') . '%')->get();
        return view('courses', compact('courses'));
    }

    public function show()
    {
        $course = Courses::find(request('id'));
        $user = auth()->user();
        
        if ($user) {
            if (CoursesUser::where('user_jmbg', $user->jmbg)->where('courses_id', $course->id)->first() != null) {
                $follows = true;
                return view('courses.show', compact('course', 'user', 'follows'));
            }
            else{
                $follows = false;
                return view('courses.show', compact('course', 'user', 'follows'));
            }
        } else {
            return redirect('/login');
        }
    }

    public function edit()
    {
        $course = Courses::find(request('id'));
        return view('courses.edit', compact('course'));
    }

    public function update()
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|required',
        ]);

        $course = Courses::find(request('id'));

        if (auth()->user()->jmbg !== (int)$course->user_id) {
            return redirect('/');
        }

        $course->name = $data['name'] ?? $course->name;
        $course->description = $data['description'] ?? $course->description;
        if (request('image')) {
            $imagePath = request('image')->store('uploads', 'public');
            Cloudinary::destroy($course->id);
            $image_stored = Cloudinary::upload(public_path("storage/{$imagePath}"), [
                'public_id' => $course->id,
            ])->getSecurePath();
            unlink(public_path("storage/{$imagePath}"));
            $course->image = $image_stored;
        }
        $course->save();

        Session::flash('message', 'Course updated successfully');

        return redirect('/teacher/courses/' . $course->id);
    }

    public function createLesson()
    {
        $course = Courses::find(request('id'));
        $user = auth()->user();
        if (auth()->user()->type !== 'predavac' && auth()->user()->jmbg !== (int)$course->user_id) {
            return redirect('/');
        }
        return view('lesson.create', compact('course', 'user'));
    }

    public function storeLesson()
    {
        $data = request()->validate([
            'fileName' => 'required',
            'fileDesc' => 'required',
        ]);

        $course = Courses::find(request('id'));
        if (auth()->user()->type !== 'predavac' && auth()->user()->jmbg !== (int)$course->user_id) {
            return redirect('/');
        }


        if (request('files') && $data['fileName'] && $data['fileDesc']) {
            foreach (request('files') as $file) {
                $lesson = new Lessons();
                $lesson->name = $data['fileName'];
                $lesson->description = $data['fileDesc'];
                $lesson->course_id = $course->id;
                $lessonPath = $file->store('uploads', 'public');
                $lesson_stored = Cloudinary::upload(public_path("storage/{$lessonPath}"), [
                    'resource_type' => 'auto',
                    'public_id' => $data['fileName'] . $course->id,
                ])->getSecurePath();
                $lesson->file = $lesson_stored;
                $lesson->save();
            }
            unlink(public_path("storage/{$lessonPath}"));
        } else if (request('link') && $data['fileName'] && $data['fileDesc']) {
            $lesson = new Lessons();
            $lesson->name = $data['fileName'];
            $lesson->description = $data['fileDesc'];
            $lesson->course_id = $course->id;
            $lesson->file = request('link');
            $lesson->save();
        } else {
            return redirect()->back()->with('message', 'Lesson not uploaded');
        }

        return redirect('/teacher/courses/' . $course->id)->with('message', 'Lesson uploaded successfully');
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
        unlink(public_path("storage/{$imagePath}"));

        auth()->user()->courses()->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $image_uploaded,
        ]);

        return redirect('/teacher');
    }

    public function destroy()
    {
        $lesson = Lessons::find(request('id'));
        if (auth()->user()->jmbg !== (int)$lesson->course->user_id) {
            return redirect('/');
        }

        Cloudinary::destroy($lesson->name . $lesson->course_id);

        $lesson->delete();

        return redirect()->back()->with('message', 'Lesson deleted successfully');
    }

    public function downloadLesson(int $lesson_id)
    {
        $lesson = Lessons::find($lesson_id);

        if (!LessonsUser::where('lesson_id', $lesson_id)->where('user_id', auth()->user()->jmbg)->exists()) {
            LessonsUser::create([
                'lesson_id' => $lesson_id,
                'user_id' => auth()->user()->jmbg,
            ]);
        }

        Session::flash('downloadFile', $lesson->file);
        return redirect()->away($lesson->file);
    }

    public function deactivate()
    {
        $course = Courses::find(request('id'));
        if (auth()->user()->jmbg !== (int)$course->user_id) {
            return redirect('/');
        }

        $pomocna = $course->status;
        $course->status = !$pomocna;
        $course->save();

        if ($pomocna == true)
            return redirect()->back()->with('message', 'Course dectivated successfully');

        return redirect()->back()->with('message', 'Course activated successfully');
    }
}
