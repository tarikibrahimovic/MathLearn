@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Create a Test</h1>

    <form action="{{ route('test.store', $course->id) }}" method="post" id="form">

        @csrf
        @method('post')
        <div class="row">
            <label for="name">Test name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="row">
            <label for="hardness">Hardnes</label>
            <select name="hardness" id="hardness">
                <option value="1">Easy</option>
                <option value="2">Medium</option>
                <option value="3">Hard</option>
            </select>
        </div>

        <button class="btn btn-primary">Create</button>
    </form>

    <button class="btn btn-primary" onclick="addQuestion()">Add a Question</button>

</div>

@endsection

@section('scripts')

<script>
    function addQuestion() {
        let form = document.getElementById('form');
        let question = document.createElement('div');
        question.classList.add('question');
        question.innerHTML = `
        <div class="row">
            <label for="question">Question</label>
            <input type="text" name="questions[]" id="question" class="form-control" required>
        </div>
        <div class="row">
            <label for="answer">Answer 1</label>
            <input type="text" name="answers[]" id="answer" class="form-control" required>
        </div>
        <div class="row">
            <label for="answer">Answer 2</label>
            <input type="text" name="answers[]" id="answer" class="form-control" required>
        </div>
        <div class="row">
            <label for="answer">Answer 3</label>
            <input type="text" name="answers[]" id="answer" class="form-control" required>
        </div>
        <div class="row">
            <label for="answer">Answer 4</label>
            <input type="text" name="answers[]" id="answer" class="form-control" required>
        </div>
        <div class="row">
            <label for="correct">Correct Answer</label>
            <select name="correct[]" id="correct">
                <option value="0">Answer 1</option>
                <option value="1">Answer 2</option>
                <option value="2">Answer 3</option>
                <option value="3">Answer 4</option>
            </select>
        </div>
        <button class="btn btn-danger" onclick="removeQuestion(this)">Remove Question</button>
        `;

        form.appendChild(question);
    }

    function removeQuestion(element) {
        element.parentElement.remove();
    }

</script>

@endsection