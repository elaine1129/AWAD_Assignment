@extends('layouts.main-layout')
@section('navbar')@stop
@section('body')
    <div class="container">
        <div class="row tw-mt-5">
            <div class="col-md-12">
                <h3>Patient Record</h3>
            </div>
            <div class="row col-md-12">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Patient record for {{$patient['name']}}</h2>
                        </div>
                        <div class="card-body">
                            @include('partials.errors')
                            @include('partials.success')
                            <div class="tw-flex tw-justify-between tw-mb-3 tw-text-gray-500 tw-flex-column md:tw-flex-row">
                                <div>
                                    <div>DATE: </div>
                                    <div class="tw-text-gray-800 tw-text-xl">{{\Carbon\Carbon::parse($created_at)->format(config('clinic.date_time'))}}</div>
                                </div>
                                <div>
                                    LAST UPDATE: {{\Carbon\Carbon::parse($updated_at)->format(config('clinic.date_time'))}}
                                </div>
                            </div>
                            <div class="form-group">
                                By Doctor: <span class="tw-text-gray-800 tw-text-xl">{{$patientRecord->doctor->name}}</span>
                            </div>
                            <form role="form" method="POST" action="{{route('patient-record.update', $id)}}" id="patient-record-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="patient_id" value="{{$patient_id}}">
                                @include('patient.record._form')

                                <div class="form-group">
                                    <div class="tw-flex tw-flex-no-wrap">
                                        <div>
                                            @can('update', $patientRecord)
                                                <button type="submit" class="btn btn-primary btn-lg">Update Patient record</button>
                                            @endcan
                                            <a class="btn btn-light btn-lg" href="{{route('patient.show', $patient)}}">
                                                Back
                                            </a>
                                        </div>
                                        @can('delete', $patientRecord)
                                        <div type="button"  onclick="deleteConfirm()" class="tw-ml-auto tw-bg-red-100 tw-rounded tw-flex tw-items-center tw-justify-center tw-p-2 tw-px-3 tw-text-red-700 hover:tw-bg-red-200">
                                            <span class="iconify tw-text-3xl " data-icon="fluent:delete-28-regular"></span>
                                            Delete
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-deleteConfirmationModal :deletetitle="'Remove Record'"
                               :deletedesc="'Are you sure to remove this record?'"
                               :deleteformaction="route('patient-record.destroy',$id)"
    ></x-deleteConfirmationModal>
@stop

@section('script')
    <script>
        const editable = {{\Illuminate\Support\Facades\Auth::user()->canany(['update','delete'], $patientRecord) ? 'true' : 'false'}};
        $("#patient-record-form").submit (function () {
            $(this).find('select').remove();

            // unset appointment id if user want to delete
            console.log($(this).find('input:checked').length)
            if($(this).find('input:checked').length == 0){
                $("<input />").attr("type", "hidden")
                    .attr("name", "appointment_id")
                    .attr("value", "")
                    .appendTo(this);
            }
            return true;
        });
        $(document).ready(function () {
            let patientTable = $('#patient-appointments').DataTable();
            patientTable.column(-1).visible(false);
        });
        $('input[type="checkbox"]').on('change', function() {
            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
        });
    </script>
@endsection
