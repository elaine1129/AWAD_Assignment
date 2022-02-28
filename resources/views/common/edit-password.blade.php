@extends('layouts.main-layout')


@section('body')
    @include('partials.errors')
    @include('partials.success')
    <form action="{{route('common.edit-password')}}" method="POST">
        @csrf
        @method('PUT')
        <div class="label">
            <label for="email"> Email: </label>
        </div>
        <div class="input">
            <input disabled type="email" placeholder="Enter your email" name="email" required value="{{$email}}" >
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

        <button type="submit">Edit</button>
        <button type="button" onclick="history.back()">Back</button>
    </form>
@endsection
@section('script')
    <script>

    </script>
@endsection
