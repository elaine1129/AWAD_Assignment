@extends('layouts.main-layout')
@section('navbar')@stop
@section('body')
    <div class="container">
        <div class="row tw-mt-5">
            <div class="col-md-12">
                <h3>Patient Record <small>» Create new record</small></h3>
            </div>
            <div class="row col-md-12">
                <div class="">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">New patient record for {{$patient['name']}}</h3></div>
                        <div class="card-body">
                            @include('partials.errors')
                            <form role="form" method="POST" action="{{route('patient-record.store')}}" id="patient-record-form">
                                @csrf
                                <input type="hidden" name="patient_id" value="{{$patient->id}}">

                                @include('patient.record._form')

                                <div class="form-group row">
                                    <div class="col-md-7">
                                        <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-plus-circle"></i>  Create new patient record</button>
                                        <button type="button" class="btn btn-light btn-lg">Cancel</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $("#patient-record-form").submit (function () {
            $(this).find('select').remove();
            return true;
        });
        $(document).ready(function () {
            $('#patient-appointments').DataTable();
        });
        $('input[type="checkbox"]').on('change', function() {
            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
        });
    </script>
    @stack('append-scripts')
@endsection
