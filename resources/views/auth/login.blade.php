@extends('layouts.main-layout')

@section('title','Login Page')

@section('body')
    <header>
        <div class="container">
            <h1> Login </h1>
        </div>
    </header>

    <body>
    <div class="login-background">
        @include('partials.success')
        @include('partials.errors')
        <div class="container">

            <div class="col">
                <!-- NO IMAGE
                <img src="img/login-pic.jpg" alt="login-pic" style="width:375px;height:400px;" />
                -->
            </div>

            <div class="tw-items-center tw-justify-center">
                <h1 class="text-primary">Login Account</h1>

                <form action="{{route('login')}}" method="post">
                    @csrf
                    <input type="text" name="email" placeholder="email" required value="{{old('email')}}">
                    <input type="password" name="password" placeholder="Password" required value="{{old('password')}}">
                    <label>
                        Remember me?
                        <input type="checkbox" name="remember" value="yes">
                    </label>

                    <input type="submit" name="login" value="Login">
                </form>
                <div class="bottom-container">
                    <br>
                    <span class="rgt">No account?<a href="{{route('register-form')}}"> Register now!!</a></span>
                </div>
            </div>
        </div>
    </div>
@endsection

