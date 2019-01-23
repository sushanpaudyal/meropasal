@extends('frontend.includes.front_design')

@section('content')

    <div class="container text-center">

        <div class="content-404">
            <h1><b>OPPS!</b> We Couldn’t Find this Page</h1>
            <p>Uh... So it looks like you brock something. The page you are looking for has up and Vanished.</p>
            <h2><a href="{{route('indexpage')}}">Bring me back Home</a></h2>
        </div>
    </div>

    @endsection