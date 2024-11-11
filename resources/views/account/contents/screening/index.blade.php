@extends('layouts.app')

@section('content')
<h1>Isi Skrining Psikologi</h1>
<form action="{{ route('patient_screening.submit') }}" method="POST">
    @csrf
    @foreach($questions as $question)
    <div>
        <p>{{ $question->question_text }}</p>
        @foreach($question->options as $option)
        <input type="radio" name="responses[{{ $question->id }}]" value="{{ $option->id }}">
        {{ $option->option_text }} ({{ $option->weight }})
        @endforeach
    </div>
    @endforeach
    <button type="submit">Submit</button>
</form>
@endsection