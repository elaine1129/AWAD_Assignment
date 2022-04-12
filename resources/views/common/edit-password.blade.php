@extends('layouts.main-layout')


@section('body')
    @include('partials.errors')
    @include('partials.success')
    <div class="container row">
        <h1 class="col-12">Reset Password</h1>
        <form action="{{route('common.edit-password')}}" method="POST" class="col-md-8 mx-auto">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="email"> Email: </label>
                <input class="form-control" disabled type="email" placeholder="Enter your email" name="email" required value="{{$email}}" >
            </div>

            <div class="form-group">
                <label for="password">Old Password*:</label>
                <input class="form-control" type="password" placeholder="Minimum 6 characters" name="old_password">
            </div>

            <div class="form-group">
                <label for="password">New Password*:</label>
                <input class="form-control" type="password" placeholder="Minimum 6 characters" name="password">
            </div>

            <div class="form-group">
                <label for="password">Password confirmation*:</label>
                <input class="form-control" type="password" placeholder="Minimum 6 characters" name="password_confirmation">
            </div>

            <div class="mt-2">
                <button class="btn btn-primary" type="submit">Edit</button>
                <button class="btn" type="button" onclick="history.back()">Back</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>

    </script>
@endsection
