@extends('layouts.app')

@section('content')

<div class="container">

    <button onclick="window.history.back()" class="btn btn-primary my-3">
        < Go Back</button>

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
                        <option value="1" selected>Easy</option>
                        <option value="2">Medium</option>
                        <option value="3">Hard</option>
                    </select>
                </div>
                <div id="question"></div>
                <button class="btn btn-primary mt-3" onclick="addQuestion()" type="button">Add a Question</button>
                <button class="btn btn-primary mt-3 mx-3">Create</button>
            </form>


</div>

@endsection

@section('scripts')

<script>
    function addQuestion() {
        let form = document.getElementById('form');
        let question = document.getElementById('question');
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
                <option value="0" selected>Answer 1</option>
                <option value="1">Answer 2</option>
                <option value="2">Answer 3</option>
                <option value="3">Answer 4</option>
            </select>
        </div>
        <button class="btn btn-danger my-3" onclick="removeQuestion(this)">Remove Question</button>
        `;

        // form.appendChild(question);
    }

    function removeQuestion(element) {
        element.parentElement.remove();
    }
</script>

@endsection