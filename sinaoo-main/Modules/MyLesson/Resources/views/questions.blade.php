@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? config('app.name', 'Laravel') }}</h1>

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('danger'))
    <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
        {{ session('danger') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <form action="{{ route('lesson.store', $lessondetail->id) }}" method="POST"> @csrf
            <div class="col">
                <ol>
                @forelse ($questions->shuffle() as $q)
                    <input type="hidden" name="soal[]" value="{{ $q->id }}">
                    <li class="mt-3">
                        {!! $q->question !!}
                        @php
                            // $jawaban = $q->lesson_question_answers->inRandomOrder()->get();
                        @endphp
                        {{-- @foreach($q->lesson_question_answers->inRandomOrder() as $a) --}}
                        @foreach($q->lesson_question_answers->shuffle() as $a)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{ "jawaban-$q->id" }}" id="{{ $q->id . $loop->iteration}}" value="{{ $a->id }}">
                            {{-- <input class="form-check-input" type="radio" name="jawaban[]" id="{{ $q->id . $loop->iteration}}" value="{{ $a->id }}"> --}}
                            <label class="form-check-label" for="{{ $q->id . $loop->iteration}}">
                            {!! $a->answer !!}
                            </label>
                        </div>
                        @endforeach
                    </li>
                @empty
                    <em>No questions yet?</em>
                @endforelse
                </ol>
                <button type="submit" class="btn btn-success">SUBMIT</button>
            </div>
        </form>

    </div>
@endsection
