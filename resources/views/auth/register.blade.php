@extends('layouts.main-layout')

@section('title','Register Page')

@section('body')
    <header>
        <div class="container">
            <h1> Register </h1>
        </div>
    </header>

    @include('partials.errors')
    <h1 class="tw-items-center tw-justify-center">Register a account!</h1>
    <div class="signupform container">
        <form action="{{route('register')}}" method="POST">
            @csrf

            <div class="label">
                <label for="email"> Email*: </label>
            </div>
            <div class="input">
                <input type="email" placeholder="Enter your email" name="email" required value="{{old('email')}}">
            </div>

            <div class="label">
                <label for="password">Password*:</label>
            </div>
            <div class="input">
                <input type="password" placeholder="Minimum 6 characters" name="password" required value="{{old('password')}}">
            </div>

            <div class="label">
                <label for="password">Password confirmation*:</label>
            </div>
            <div class="input">
                <input type="password" placeholder="Minimum 6 characters" name="password_confirmation" required value="{{old('password_confirmation')}}">
            </div>

            <div class="label">
                <label for="FullName"> Name: </label>
            </div>
            <div class="input">
                <input type="text" placeholder="name" name="name" required value="{{old('name')}}">
            </div>

{{--can remove first name and user name?--}}
{{--            <div class="label"><label></label></div>--}}
{{--            <div class="input">--}}
{{--                <input type="text" placeholder="Last name" name="last_name" required value="{{old('email')}}>--}}
{{--            </div>--}}

            <div class="label">
                <label for="phone"> Phone Number: </label>
            </div>
            <div class="input">
                <input type="text" placeholder="Ex: 0123456677" name="phone" required value="{{old('phone')}}">
            </div>

            <div class="label">
                <label for="address">Address: </label>
            </div>

            <textarea id="address" name="address" placeholder="Enter address"
                      style="height:50px;width:200px;">{{old('address')}}</textarea>

            <div class="label">
                <label for="gender"> Gender: </label>
            </div>
            <div class="labelgender">
                <label for="gender"><input type="radio" name="gender" required value="men" @if(old('gender')) checked @endif>Men </label>
                <label for="gender"><input type="radio" name="gender" required value="women" @if(old('gender')) checked @endif>Women </label>
            </div>

            <div class="signup">
                <input type="submit" name="register" value="Register">
            </div>

            <p style="font-size:15px;">By signing up, you agree to our <b>Policy</b>.</p><br>
            <p>Have an account?<a href="{{route('login-form')}}"> Log in</a></p>
        </form>

    </div>

@endsection
@section('script')
@endsection
