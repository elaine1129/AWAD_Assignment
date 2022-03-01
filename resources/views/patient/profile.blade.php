@extends('layouts.main-layout')
@section('title', "Patient - ".$patient['name'])
@section('styles')
    <style>

    </style>
@endsection
@section('body')
    <div
        class="scrollToTop tw-fixed tw-bottom-0 tw-right-5 lg:tw-right-15 tw-h-16 tw-w-20 tw-bg-blue-50 tw-py-2 tw-px-1 tw-z-10 tw-shadow-md tw-cursor-pointer hover:tw-bg-blue-100">
        <div class="text-center font-weight-bold tw-text-primary">&uparrow; To top</div>
    </div>
    <div class="container">
        <h2>Patients profile:</h2>
        <hr>
        <div class="tw-grid tw-grid-cols-5" id="profile">
            <div class="patient-profile-card tw-relative tw-mt-5 ">
                <span
                    class="tw-absolute tw-text-indigo-800 tw--top-7 tw-bg-blue-200 tw-p-[0.8rem] tw-rounded-full tw-flex tw-items-center tw-justify-center">
                    <span class="iconify tw-text-4xl" data-icon="carbon:user-profile"></span>
                </span>
                <div class="tw-mt-5">
                    <div>Name</div>
                    <div>{{$patient['name']}}</div>
                </div>
                <div>
                    <div>Email</div>
                    <div>{{$patient['email']}}</div>
                </div>
                <div>
                    <div>Phone</div>
                    <div>{{$patient['data']['phone']}}</div>
                </div>
                <div>
                    <div>IC</div>
                    <div>{{$patient['data']['ic']}}</div>
                </div>
                <div>
                    <div>Gender</div>
                    <div>{{$patient['data']['gender']}}</div>
                </div>
                <div>
                    <div>Address</div>
                    <div>
                        <address>
                            {{$patient['data']['address']}}
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
            <div class="container tw-mt-5">
                @include('partials.success')
                @include('partials.errors')
            </div>

            <div class="container" id="record">
                <h2>Patient records:</h2>
                @can('doctor-access')
                    <div class="text-right py-2">
                        <a href="{{route('patient-record.create',$patient['id'])}}" class="btn btn-success"><i
                                class="fa fa-plus-circle"></i> Add new records
                        </a>
                    </div>
                @endcan
                <table id="patient-records" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Symptoms</th>
                        <th>Diagnosis</th>
                        <th>Prescription</th>
                        <th>Doctor</th>
                        <th data-sortable="false">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($patient['patient_records'] as $patient_record)
                        <tr id="{{$patient_record['id']}}">
                            <td class="index"></td>
                            <td>{{ \Carbon\Carbon::parse($patient_record['created_at'])->format(config('clinic.date_format')) }}</td>
                            <td>
                                <div class="two-lines-text">
                                    {{ $patient_record['symptoms'] }}
                                </div>
                            </td>
                            <td>
                                {{ $patient_record['diagnosis'] }}
                            </td>
                            <td>
                                <div class="two-lines-text">
                                    {{ $patient_record['prescription'] }}
                                </div>
                            </td>
                            <td>{{ $patient_record['doctor']['name'] }}</td>
                            <td>
                                <a class="btn btn-primary"
                                   href="{{route('patient-record.edit', $patient_record)}}">
                                    {{Auth::user()->canany(['update','delete'], $patient_record) ? 'Edit' : 'View'}}
                                </a>
                                @can('delete', $patient_record)
                                <button type="button" class="btn btn-outline-danger"
                                        onclick="deletePatientRecord(`{{route('patient-record.destroy', $patient_record)}}`, {{$patient_record->id}})">
                                    Delete
                                </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


            <div class="container tw-pb-10" id="appointment">
                <h2>Appointment booked:</h2>
                @can('patient-access')
                    <div class="text-right py-2">
                        <a class="btn btn-success" href="/"><i class="fa fa-plus-circle"></i> Create new Appointment
                        </a>
                    </div>
                @endcan
                <ul class="nav nav-tabs" id="appontmentTab" role="tablist" style="cursor:pointer;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pending-appt" data-toggle="tab" href="#pending" role="tab"
                           aria-controls="pending-appt"
                           aria-selected="true">Pending</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="upcoming-appt" data-toggle="tab" href="#upcoming" role="tab"
                           aria-controls="upcoming-appt"
                           aria-selected="false">Upcoming</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="completed-appt" data-toggle="tab" href="#completed" role="tab"
                           aria-controls="completed-appt"
                           aria-selected="false">Completed</a>
                    </li>
                </ul>
                <div>
                    <div class="tab-content" id="appointmentTabContent">
                        <div class="tab-pane fade show active tw-pt-3" id="pending" role="tabpanel"
                             aria-labelledby="pending-appt">
                            <table id="pending-appointment" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Visit Time</th>
                                    <th>Doctor</th>
                                    <th>Condition</th>
                                    <th>Request Status</th>
                                    @canany(['admin-access','doctor-access'])
                                        <th data-sortable="false">Action</th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($patient->getPendingAppointment() as $appointment)
                                    <tr>
                                        <td>{{ $appointment['schedule']? $appointment['date'] : '-' }}</td>
                                        <td>{{ $appointment['timeslot'] ? $appointment['time'] : '-' }}</td>
                                        <td>{{ $appointment['doctor']['name'] }}</td>
                                        <td>{{ $appointment['condition'] }}</td>
                                        <td>{{ $appointment['status'] }}</td>
                                        @canany(['admin-access','doctor-access'])
                                            <td>
                                                <button type="button" class="btn btn-success" data-toggle="modal"
                                                        data-target="#approveModal">Approve
                                                </button>
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade tw-pt-3" id="upcoming" role="tabpanel"
                             aria-labelledby="upcoming-appt">
                            <table id="upcoming-appointment" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Visit Time</th>
                                    <th>Doctor</th>
                                    <th>Condition</th>
                                    <th>Status</th>
                                    @canany(['admin-access','doctor-access'])
                                        <th data-sortable="false">Actions</th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($patient->getApprovedAppointment() as $appointment)
                                    <tr>
                                        <td>{{ $appointment['schedule']? $appointment['date'] : '-' }}</td>
                                        <td>{{ $appointment['timeslot'] ? $appointment['time'] : '-' }}</td>
                                        <td>{{  $appointment['doctor']['name'] }}</td>
                                        <td>{{ $appointment['condition'] }}</td>
                                        <td>{{ $appointment['status'] }}</td>
                                        @canany(['admin-access','doctor-access'])
                                            <td>
                                    <span class="iconify" type="button" data-icon="bytesize:edit"
                                          style="color: rgb(151, 149, 149);" data-toggle="modal"
                                          data-target="#updateAppointmentModal"></span>
                                                <span class="iconify" type="button" data-icon="fluent:delete-28-regular"
                                                      style="color: red;" data-toggle="modal"
                                                      data-target="#deleteModal"></span>
                                                @can('mark-done', $appointment)
                                                    <button type="button" class="btn btn-success" onclick="markDone({{$appointment['id']}})">Mark As Done
                                                    </button>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade tw-pt-3" id="completed" role="tabpanel"
                             aria-labelledby="completed-appt">
                            <table id="completed-appointment" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Visit Time</th>
                                    <th>Doctor</th>
                                    <th>Condition</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($patient->getDoneAppointment() as $appointment)
                                    <tr>
                                        <td>{{ $appointment['schedule']? $appointment['date'] : '-' }}</td>
                                        <td>{{ $appointment['timeslot'] ? $appointment['time'] : '-' }}</td>
                                        <td>{{  $appointment['doctor']['name'] }}</td>
                                        <td>{{ $appointment['condition'] }}</td>
                                        <td>{{ $appointment['status'] }}</td>
                                    </tr>
                                @endforeach
                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-deleteConfirmationModal :deletetitle="'Delete Patient Record'"
                               :deletedesc="''"></x-deleteConfirmationModal>
    <x-confirmationModal :title="''" :desc="''"/>
@endsection
@section('script')
    <script>

        $(document).ready(function () {
            let patientRecord = $('#patient-records').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [[1, 'asc']]
            });

            patientRecord.on('order.dt search.dt', function () {
                patientRecord.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            // $('#patient-appointments').DataTable();
            $('#completed-appointment').DataTable();
            $('#upcoming-appointment').DataTable();
            $('#pending-appointment').DataTable();
        });

        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.scrollToTop').fadeIn();
            } else {
                $('.scrollToTop').fadeOut();
            }
        });

        //Click event to scroll to top
        $('.scrollToTop').click(function () {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });

        function markDone(id){
            let path = '/doctor/mark-appointment-done/' + id
            confirmModal(()=> {
                window.location.href = path;
            }, 'Mark as done', 'Are you sure to mark this appointment as completed?')
        }

        function deletePatientRecord(path, id) {
            let index = $(`#${id} .index`).html()
            $('#modalDesc').html("Are you sure to delete record <span class='tw-text-highlight-blue'>" + index + "</span> ?")
            $('#modalDeleteForm').attr('action', path)
            $('#deleteModal').modal().show()
        }
    </script>
@stop

