@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            @include('layouts.partials.items')
        </div>
    </div>
@endsection
