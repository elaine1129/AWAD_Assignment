@extends('layouts.main-layout')

@section('body')
    <code>
        {{Auth::user()}}
    </code>

    <a href="{{route('logout')}}">Logout</a>

    <pre>
        navbar here
    </pre>

    <pre>
        {{Auth::user()->appoinments}}
    </pre>

@endsection
