@extends('layouts.main-layout')

@section('body')
@include('partials.errors')
@include('partials.success')
<form action="{{route('register-doctor')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-11 mx-auto">
            <div class="card border-0">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-10">
                            <h2>Register Doctor</h2>
                            <br>
                        </div>
                    </div>

                    <div class="label">
                        <label for="email"> Email*: </label>
                    </div>
                    <div class="input">
                        <input style="width:35%" type="email" placeholder="Enter your email" name="email" required value="{{old('email')}}">
                    </div>
                
                    <div class="label">
                        <label for="name"> Name: </label>
                    </div>
                    <div class="input">
                        <input style="width:35%" type="text" placeholder="name" name="name" required value="{{old('name')}}">
                    </div>
                
                    <div class="label">
                        <label for="name"> Expertise: </label>
                    </div>
                    <div class="input">
                        <input style="width:35%" type="text" placeholder="expertise" name="expertise" required value="{{old('expertise')}}">
                    </div>
                
                    <div class="label">
                        <label for="name"> Profile image: </label>
                    </div>
                    <div class="input">
                        <input type="file" name="image">
                    </div>
                    <br>
                
                    <button type="submit">Create new doctor</button>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="label">
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

    <button type="submit">Create new doctor</button> --}}
</form>
@endsection
@section('script')
    <script>

    </script>
@endsection
