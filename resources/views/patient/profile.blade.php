@extends('layouts.main-layout')
@section('title', "Patient - ".$patient['name'])
@section('styles')
    <style>

    </style>
@endsection
@section('body')
    <div class="container">
        @include('partials.success')
        @include('partials.errors')
        <h2>Patients profile:</h2>
        <hr>
        <div class="tw-grid tw-grid-cols-5" id="profile">
            <div class="patient-profile-card tw-relative tw-mt-5 ">
                <span class="tw-absolute tw-text-indigo-800 tw--top-7 tw-bg-blue-200 tw-p-[0.8rem] tw-rounded-full tw-flex tw-items-center tw-justify-center">
                    <span class="iconify tw-text-4xl"  data-icon="carbon:user-profile"></span>
                </span>
                <div class="tw-mt-5">
                    <div >Name</div>
                    <div>{{$patient['name']}}</div>
                </div>
                <div>
                    <div >Email</div>
                    <div>{{$patient['email']}}</div>
                </div>
                <div >
                    <div>Phone</div>
                    <div>{{$patient['phone']}}</div>
                </div>
                <div >
                    <div>IC</div>
                    <div>{{$patient['ic']}}</div>
                </div>
                <div >
                    <div>Gender</div>
                    <div>{{$patient['gender']}}</div>
                </div>
                <div >
                    <div>Address</div>
                    <div>
                        <address>
                            {{$patient['address']}}
                        </address>
                    </div>
                </div>
            </div>
            <div class="tw-col-span-5 md:tw-col-span-2 tw-p-5">
                <h6>Navigation</h6>
                <hr>
                <ul>
                    <li><a class="text-" href="#profile">Profile</a></li>
                    <li><a class="text-" href="#record">Records</a></li>
                    <li><a class="text-" href="#appointment">Appointments</a></li>
                </ul>
            </div>
        </div>

        <div class="tw-space-y-10">
            <div class="container">

            </div>

            <div class="container" id="record">
                <h2>Patient records:</h2>
                <div class="text-right py-2">
                    <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#modal-folder-create"><i class="fa fa-plus-circle"></i> Add new records (for admin & doctor only)
                    </button>
                </div>
                <table id="patient-records" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Symptoms</th>
                        <th>Diagnosis</th>
                        <th>Prescription</th>
                        <th>Doctor</th>
                        <th data-sortable="false">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!is_null($patient['patient_records']))
                        @foreach ($patient['patient_records'] as $patient_record)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($patient_record['created_at'])->format(config('clinic.date_format')) }}</td>
                            <td>
                                <div class="two-lines-text">
                                    {{ $patient_record['symptoms'] }}
                                </div>
                            </td>
                            <td>
                                    {{ $patient_record['diagnosis'] }}
                            </td>
                            <td >
                                <div class="two-lines-text">
                                    {{ $patient_record['prescription'] }}
                                </div>
                            </td>
                            <td>{{ $patient_record['doctor']['name'] }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#approveModal">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-outline-danger"
                                        onclick="deletePatient(`patients/{{$patient['id']}}`,`{{$patient['name']}}`)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>


            <div class="container" id="appointment">
                <h2>Appointment booked:</h2>
                <div>
                    <div class="text-right py-2">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#modal-folder-create"><i class="fa fa-plus-circle"></i> Create new Appointment (for patient only)
                        </button>
                    </div>
                        <table id="patient-appointments" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Visit Time</th>
                                <th>Doctor</th>
                                <th>Condition</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($patient['appointments']))
                            @foreach ($patient['appointments'] as $appointment)
                                <tr>
                                    <td>{{ $appointment['patient']['name'] }}</td>
                                    <td>{{ $appointment['patient']['email'] }}</td>
                                    <td>{{ $appointment['schedule']? $appointment['date'] : '-' }}</td>
                                    <td>{{ $appointment['timeslot'] ? $appointment['time'] : '-' }} }}</td>
                                    <td>{{  $appointment['doctor']['name'] }}</td>
                                    <td>{{ $appointment['condition'] }}</td>
                                    <td>{{ $appointment['status'] }}</td>
                                </tr>
                            @endforeach
                            @endif
                            <tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>

        $(document).ready(function () {
            $('#patient-records').DataTable();
            $('#patient-appointments').DataTable();
        });

        // function deletePatient(path, name) {
        //     $('#modalDesc').html("Are you sure to delete patient <span class='tw-text-highlight-blue'>" + name + "</span> ?")
        //     $('#modalDeleteForm').attr('action', path)
        //     $('#deleteModal').modal().show()
        // }

    </script>
@stop

