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

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">

        @foreach($lessons as $lesson)
        <div class="col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2" style="background-color: {{ $lesson->color }}; cursor: pointer" onclick="window.location.href='{{ route('lesson.home', $lesson->id) }}'">
                <div class="card-body text-white">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $lesson->lesson_category->name }} @if($lesson->is_paid == 1) <sup><small>Premium</small></sup> @endif</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $lesson->name }}  </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-brain fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach


    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $lessons->links() }}
        </div>
    </div>
@endsection
