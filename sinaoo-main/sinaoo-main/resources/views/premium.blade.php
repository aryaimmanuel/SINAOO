@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

    <!-- Main Content goes here -->
    @php
        if(Auth::user()->is_premium == 0){
            $t = "Freemium";
        }else{
            $t = "Premium";
        }
    @endphp

    <div class="card">
        <div class="card-header">
            Akun {{ $t }}
        </div>
        <div class="card-body">
            <h4 class="card-title">{{  Auth::user()->fullName }}</h4>
            <p class="card-text">{{ $t }}</p>

            @if(Auth::user()->is_premium == 0)
                <form action="{{ route('premium') }}" method="post">@csrf
                    @php
                        $kode = "SIN-" . Auth::id() . "-" . time();
                        $price = config('app.price');
                    @endphp
                    <input type="hidden" id="kode" value="{{ $kode }}">
                    <input type="hidden" id="price" value="{{ $price }}">
                    <button class="btn btn-success" type="submit">Upgrade to Premium</button>
                </form>
                @if(!is_null($code))
                    <small>Payment Code: {{ $code }}</small>
                @endif
            @endif
        </div>
    </div>

    <!-- End of Main Content -->
@endsection

@push('notif')
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
@endpush
