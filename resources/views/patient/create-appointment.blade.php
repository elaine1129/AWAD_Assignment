@extends('layouts.main-layout')
@section('body')
<div class="tw-px-10 sm:tw-px-20 lg:tw-px-40">
    <h1>Create Appointment page</h1>
    <h2>Book Appointment</h2>
    <div class="tw-items-center tw-justify-center">
        <div class="h5 d-flex flex-column font-weight-bold m-3">
            <form method="post">
                <label> Doctor: </label>
                <p class="display-4"> Dr. Ulrike Herx {{-- Doctor name --}}</p>
                <label> Reason for visit: </label><br>
                <input type="text" name="reason"><br><br>
                <label> Name: </label><br>
                <input type="text" name="name"><br><br>
                <label> Phone Number: </label><br>
                <input type="text" name="phoneNum"><br><br>
                <label>Date: </label> <br>
                <input type="text" id="datepicker"><br><br>
                <label>Time: </label> <br>
                <input type="text" name="time"><br><br>
                <a href="#" class="btn btn-primary">Create appointment</a>
            </form>
        </div>
    </div>

    @endsection
    @section('script')
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>
    @stop
