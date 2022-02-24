@extends('layouts.main-layout')
@section('body')
    <div class="tw-px-10 sm:tw-px-20 lg:tw-px-40">
        <h2>Appointments:</h2>
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
        <div class="tab-content" id="appontmentTabContent">
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-appt">
                <h3>Pending</h3>
                <div class="container">
                    <table id="admin-pending-appt" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Visit Time</th>
                            <th>Doctor</th>
                            <th>Condition</th>
                            <th>Request Status</th> <!-- update request / new appointment -->
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($appointments_pending as $appointment)
                            <tr>
                                <td>{{ $appointment['patient']['name'] }}</td>
                                <td>{{ $appointment['patient']['email'] }}</td>
                                <td>{{ $appointment['schedule']? $appointment['date'] : '-' }}</td>
                                <td>{{ $appointment['timeslot'] ? $appointment['time'] : '-' }} }}</td>
                                <td>{{  $appointment['doctor']['name'] }}</td>
                                <td>{{ $appointment['condition'] }}</td>
                                <td>{{ $appointment['status'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#approveModal">Approve
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-appt">
                <h3>Upcoming</h3>
                <div class="container">
                    <table id="admin-upcoming-appt" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Visit Time</th>
                            <th>Doctor</th>
                            <th>Condition</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($appointments_upcoming as $appointment)
                            <tr>
                                <td>{{ $appointment['patient']['name'] }}</td>
                                <td>{{ $appointment['patient']['email'] }}</td>
                                <td>{{ $appointment['schedule']? $appointment['date'] : '-' }}</td>
                                <td>{{ $appointment['timeslot'] ? $appointment['time'] : '-' }} }}</td>
                                <td>{{  $appointment['doctor']['name'] }}</td>
                                <td>{{ $appointment['condition'] }}</td>
                                <td>{{ $appointment['status'] }}</td>
                                <td>
                                    <span class="iconify" type="button" data-icon="bytesize:edit"
                                          style="color: rgb(151, 149, 149);" data-toggle="modal"
                                          data-target="#updateAppointmentModal"></span>
                                    <span class="iconify" type="button" data-icon="fluent:delete-28-regular"
                                          style="color: red;" data-toggle="modal" data-target="#deleteModal"></span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-appt">
                <h3>Completed</h3>
                <div class="container">
                    <table id="admin-completed-appt" class="table table-striped table-bordered">
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
                        @foreach ($appointments_completed as $appointment)
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
                        <tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-adminUpdateAppointmentModal :title="'Update Appointment'"/>
    <x-confirmationModal :title="'Approve Pending Appointment'" :desc="'Are you sure to approve this appointment?'"/>
    <x-deleteConfirmationModal :deletetitle="'Remove Appointment'"
                               :deletedesc="'Are you sure to remove this appointment?'"></x-deleteConfirmationModal>
    </body>
@endsection
@section('script')
    <script>

        $(document).ready(function () {
            $('#admin-pending-appt').DataTable();
            $('#admin-upcoming-appt').DataTable();
            $('#admin-completed-appt').DataTable();
        });

    </script>
@stop
