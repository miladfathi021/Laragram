@extends('layouts.app')

@section('content')
    <div class="container">
        <post-page :data="{{ $posts }}"></post-page>
    </div>
@endsection
