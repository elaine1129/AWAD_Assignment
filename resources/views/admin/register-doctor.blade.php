@extends('layouts.main-layout')

@include('partials.errors')
@include('partials.success')
@section('body')
<form action="{{route('register-doctor')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="label">
        <label for="email"> Email*: </label>
    </div>
    <div class="input">
        <input type="email" placeholder="Enter your email" name="email" required value="{{old('email')}}">
    </div>

    <div class="label">
        <label for="name"> Name: </label>
    </div>
    <div class="input">
        <input type="text" placeholder="name" name="name" required value="{{old('name')}}">
    </div>

    <div class="label">
        <label for="name"> Expertise: </label>
    </div>
    <div class="input">
        <input type="text" placeholder="expertise" name="expertise" required value="{{old('expertise')}}">
    </div>

    <div class="label">
        <label for="name"> Profile image: </label>
    </div>
    <div class="input">
        <input type="file" name="image">
    </div>

    <button type="submit">Create new doctor</button>
</form>
@endsection
@section('script')
    <script>

    </script>
@endsection
