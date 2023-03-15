<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Session;
use App\Models\Courses;
use App\Models\Question;
use App\Models\Answer;

class TestController extends Controller
{
    //

    public function create(int $course_id)
    {
        $course = Courses::find($course_id);
        return view('test.create', compact('course'));
    }

    public function storeQuestion(int $test_id){

        if (request()->has('questions') && request()->has('answers') && request()->has('correct')) {

            for ($i = 0; $i < count(request('questions')); $i++) {
                $question = Question::create([
                    'question' => request('questions')[$i],
                    'tests_id' => $test_id
                ]);
                for ($j = 0; $j < count(request('answers')); $j++) {

                    Answer::create([
                        'answer' => request('answers')[$j],
                        'is_correct' => request('correct')[$i] == $j ? true : false,
                        'questions_id' => $question->id
                    ]);
                }
            }
            Session::flash('message', 'Test is successfully created!');
        } else {
            Session::flash('message', 'Test is not created!');
        }

        //return back with message
        return redirect()->back()->with('message', 'Question is successfully created!');
    }

    public function store(int $course_id)
    {

        if (request()->has('questions') && request()->has('answers') && request()->has('correct')) {
            $data = request()->validate([
                'name' => 'required|string',
                'hardness' => 'required|integer',
            ]);

            Test::create([
                'name' => $data['name'],
                'hardness' => $data['hardness'],
                'courses_id' => $course_id
            ]);
            $test = Test::where('name', $data['name'])->first();
            for ($i = 0; $i < count(request('questions')); $i++) {
                Question::create([
                    'question' => request('questions')[$i],
                    'tests_id' => $test->id
                ]);
                for ($j = 0; $j < count(request('answers')); $j++) {

                    Answer::create([
                        'answer' => request('answers')[$j],
                        'is_correct' => request('correct')[$i] == $j ? true : false,
                        'questions_id' => $test->questions()->first()->id
                    ]);
                }
            }
            Session::flash('message', 'Test is successfully created!');
        } else {
            Session::flash('message', 'Test is not created!');
        }

        return redirect()->route('courses.show', $course_id);
    }

    public function show(int $test_id)
    {
        $test = Test::find($test_id);
        return view('test.show', compact('test'));
    }

    public function edit(int $test_id)
    {
        $test = Test::find($test_id);
        return view('test.edit', compact('test'));
    }

    public function destroyQuestions(int $question_id){
        $question = Question::find($question_id);
        $question->delete();
        return redirect()->back()->with('message', 'Question is successfully deleted!');
    }

    public function destroy(int $test_id)
    {
        $test = Test::find($test_id);
        $test->delete();
        return redirect()->back()->with('message', 'Test is successfully deleted!');
    }
}
