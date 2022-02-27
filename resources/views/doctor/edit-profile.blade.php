@extends('layouts.main-layout')

@include('partials.errors')
@include('partials.success')
@section('body')
    <form action="{{route('doctor.edit-profile')}}" method="POST" enctype="multipart/form-data">
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

        <div class="label">
            <label for="password">Old Password*:</label>
        </div>
        <div class="input">
            <input type="password" placeholder="Minimum 6 characters" name="old_password">
        </div>

        <div class="label">
            <label for="password">New Password*:</label>
        </div>
        <div class="input">
            <input type="password" placeholder="Minimum 6 characters" name="password">
        </div>

        <div class="label">
            <label for="password">Password confirmation*:</label>
        </div>
        <div class="input">
            <input type="password" placeholder="Minimum 6 characters" name="password_confirmation">
        </div>

        <div class="label">
            <label for="name"> Expertise: </label>
        </div>
        <div class="input">
            <input type="text" placeholder="expertise" name="expertise" required value="{{$expertise ?? ''}}">
        </div>

        <div class="label">
            <label for="name"> Profile image: </label>
        </div>
        <div class="input">
            <img id="image-preview" src="{{$image_url ?? ''}}" alt="">
            <input type="file" name="image">
        </div>

        <button type="submit">Edit</button>
    </form>
@endsection
@section('script')
    <script>

    </script>
@endsection
