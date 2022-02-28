@extends('layouts.main-layout')


@section('body')
    @include('partials.errors')
    @include('partials.success')

    <form action="{{route('common.edit-profile')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="label">
            <label for="email"> Email: </label>
        </div>
        <div class="input">
            <input disabled type="email" placeholder="Enter your email" name="email" required value="{{$email}}" >
        </div>

        <div class="label">
            <label for="name"> Name: </label>
        </div>
        <div class="input">
            <input type="text" placeholder="name" name="name" required value="{{$name}}">
        </div>

        @include('common._profile-form')

        <button type="submit">Edit</button>
        <button type="button" onclick="history.back()">Back</button>
    </form>
@endsection
@section('script')
    <script>

    </script>
@endsection
