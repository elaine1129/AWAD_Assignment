 @extends('layouts.main-layout')
 @section('body')
     <div class="tw-px-10 sm:tw-px-20 lg:tw-px-40">
         <h2>Appointments:</h2>
         <ul class="nav nav-tabs" id="appontmentTab" role="tablist" style="cursor:pointer;">
             <li class="nav-item" role="presentation">
                 <a class="nav-link active" id="upcoming-appt" data-toggle="tab" href="#upcoming" role="tab"
                     aria-controls="upcoming-appt" aria-selected="false">Upcoming</a>
             </li>
             <li class="nav-item" role="presentation">
                 <a class="nav-link" id="completed-appt" data-toggle="tab" href="#completed" role="tab"
                     aria-controls="completed-appt" aria-selected="false">Completed</a>
             </li>
         </ul>
         <div class="tab-content" id="appontmentTabContent">
             <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-appt">

                 <h3>Upcoming</h3>
                 <div class="container">
                     <table id="doctor-upcoming-appt" class="table table-striped table-bordered">
                         <thead>

                             <tr>
                                 <th>Patient Name</th>
                                 <th>Email</th>
                                 <th>Date</th>
                                 <th>Visit Time</th>
                                 <th>Doctor</th>
                                 <th>Condition</th>
                                 <th>Request Status</th>
                                 <th>Actions</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($appointments_upcoming as $appointment)
                                 <tr>
                                     <td>{{ $appointment['patient']['name'] }}</td>
                                     <td>{{ $appointment['patient']['email'] }}</td>
                                     <td>{{ $appointment['date'] }}</td>
                                     <td>{{ $appointment['time'] }} </td>
                                     <td>{{ $appointment['doctor']['name'] }}</td>
                                     <td>{{ $appointment['condition'] }}</td>
                                     <td>{{ $appointment['status'] }}</td>
                                     <td>
                                         <button type="button" class="btn btn-success"
                                             onclick="completeAppointment(`/doctor/mark-appointment-completed/{{ $appointment['id'] }}`)">Completed</button>
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
                     <table id="doctor-completed-appt" class="table table-striped table-bordered">
                         <thead>
                             <tr>
                                 <th>Patient Name</th>
                                 <th>Email</th>
                                 <th>Date</th>
                                 <th>Visit Time</th>
                                 <th>Doctor</th>
                                 <th>Condition</th>
                                 <th>Request Status</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($appointments_completed as $appointment)
                                 <tr>
                                     <td>{{ $appointment['patient']['name'] }}</td>
                                     <td>{{ $appointment['patient']['email'] }}</td>
                                     <td>{{ $appointment['date'] }}</td>
                                     <td>{{ $appointment['time'] }} </td>
                                     <td>{{ $appointment['doctor']['name'] }}</td>
                                     <td>{{ $appointment['condition'] }}</td>
                                     <td>{{ $appointment['status'] }}</td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
     </body>
     @include('partials.modal.confirm')
 @endsection
 @section('script')
     <script>
         $(document).ready(function() {
             $('#doctor-upcoming-appt').DataTable();
             $('#doctor-completed-appt').DataTable();
         });

         function completeAppointment(path) {
             confirmModal({
                 title: 'Complete Appointment',
                 message: "Are you sure to complete this appointment?",
                 callback: () => {
                     window.location.href = path;
                 }
             })
         }
     </script>
 @stop
