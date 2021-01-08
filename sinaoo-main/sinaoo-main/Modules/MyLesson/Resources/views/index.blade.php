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

        <div class="col">
            <div class="accordion" id="accordionExample">
                @foreach($lesson->lesson_details as $lesson)
                    <div class="card">
                        <div class="card-header text-center" id="heading{{ $loop->iteration }}">
                            <h2 class="mb-0">
                            <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                                Minggu {{ $loop->iteration }}
                            </button>
                            </h2>
                        </div>

                        <div id="collapse{{ $loop->iteration }}" class="collapse @if($loop->first) show @endif" aria-labelledby="heading{{ $loop->iteration }}" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $lesson->name }}</div>
                                <hr>
                                {!! $lesson->description !!}

                                <hr>
                                <div class="row">
                                    <div class="col-md-1">
                                        <p><strong>Post Test</strong></p>
                                        <a class="btn btn-primary" href="{{ route('lesson.questions', $lesson->id) }}" role="button">Start</a>
                                    </div>
                                    <div class="col">
                                        <p><strong>Nilai</strong></p>
                                        {{ $lesson->lesson_quizzes()->where('user_id', auth()->id())->sum('point') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
