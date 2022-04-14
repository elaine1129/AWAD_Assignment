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
            <div class="patient-profile-card tw-relative tw-mt-5 tw-min-w-min">
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

        </div>
    </div>
    @include('partials.modal.confirm')
    @include('partials.modal.delete')
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

        function markDone(id) {
            let path = '/mark-appointment-done/' + id

            confirmModal({
                title: 'Mark as done',
                message: 'Are you sure to mark this appointment as completed?',
                callback: () => {
                    window.location.href = path;
                }
            })
        }

        function deletePatientRecord(path, id) {
            let index = $(`#${id} .index`).html()
            deleteModal({
                title: 'Delete patient record',
                message: "Are you sure to delete record <span class='tw-text-highlight-blue'>" + index + "</span> ?",
                action: path
            })
        }
    </script>
@stop

