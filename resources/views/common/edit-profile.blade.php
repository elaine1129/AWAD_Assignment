@extends('layouts.main-layout')


@section('body')
    @include('partials.errors')
    @include('partials.success')

    <form id="profile-form" action="{{route('common.edit-profile')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-11 mx-auto">
                <div class="card border-0">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-10">
                                <h2>Edit Profile</h2>
                                <br>
                            </div>
                        </div>

                        <div class="label">
                            <label for="email"> Email: </label>
                        </div>
                        <div class="input">
                            <input style="width:35%" disabled type="email" placeholder="Enter your email" name="email" required value="{{$email}}" >
                        </div>
                
                        <div class="label">
                            <label for="name"> Name: </label>
                        </div>
                        <div class="input">
                            <input style="width:35%" type="text" placeholder="name" name="name" required value="{{$name}}">
                        </div>
                
                        @include('common._profile-form')
                
                        <br>
                        <button type="submit">Edit</button>
                        <button type="button" onclick="history.back()">Back</button>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- <div class="label">
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
        <button type="button" onclick="history.back()">Back</button> --}}
    </form>
@endsection
@section('script')
    <script>

    @if (Route::is('doctor.edit'))
        @can('admin-access')
            let id = window.location.href.split('/')[5]
            $('#profile-form').attr('action', '/admin/doctors/'+ id +'/edit')
        @endcan
    @endif
    </script>
@endsection
