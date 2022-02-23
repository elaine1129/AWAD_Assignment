 @extends('layouts.main-layout')
 @section('body')
     <div class="tw-px-10 sm:tw-px-20 lg:tw-px-40">
         <h2>Appointments:</h2>
         <ul class="nav nav-tabs" id="appontmentTab" role="tablist" style="cursor:pointer;">
             <li class="nav-item" role="presentation">
                 <a class="nav-link active" id="upcoming-appt" data-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming-appt"
                     aria-selected="false">Upcoming</a>
             </li>
             <li class="nav-item" role="presentation">
                 <a class="nav-link" id="completed-appt" data-toggle="tab" href="#completed" role="tab" aria-controls="completed-appt"
                     aria-selected="false">Completed</a>
             </li>
         </ul>
         <div class="tab-content" id="appontmentTabContent" >
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
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011/04/25</td>
                            <td>$320,800</td>
                            <td>
                                <button type="button" class="btn btn-success">Completed</button>
                            </td>                           
                        </tr>
                        <tr>
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>63</td>
                            <td>2011/07/25</td>
                            <td>$170,750</td>
                            <td>
                                <button type="button" class="btn btn-success">Completed</button>

                            </td>       
                        </tr>
                        <tr>
                            <td>Ashton Cox</td>
                            <td>Junior Technical Author</td>
                            <td>San Francisco</td>
                            <td>66</td>
                            <td>2009/01/12</td>
                            <td>$86,000</td>
                            <td>
                                <button type="button" class="btn btn-success">Completed</button>
                            </td>       
                        </tr>
                        </tfoot>
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
                       </tr>
                       </thead>
                       <tbody>
                       <tr>
                           <td>Tiger Nixon</td>
                           <td>System Architect</td>
                           <td>Edinburgh</td>
                           <td>61</td>
                           <td>2011/04/25</td>
                           <td>$320,800</td>
                       </tr>
                       <tr>
                           <td>Garrett Winters</td>
                           <td>Accountant</td>
                           <td>Tokyo</td>
                           <td>63</td>
                           <td>2011/07/25</td>
                           <td>$170,750</td>
                       </tr>
                       <tr>
                           <td>Ashton Cox</td>
                           <td>Junior Technical Author</td>
                           <td>San Francisco</td>
                           <td>66</td>
                           <td>2009/01/12</td>
                           <td>$86,000</td>
                       </tr>
                       </tfoot>
                   </table>
               </div>
             </div>
         </div>
     </div>
     </body>
 @endsection
 @section('script')
 <script>
    $(document).ready(function() {
        $('#doctor-upcoming-appt').DataTable();
        $('#doctor-completed-appt').DataTable();
    } );
</script>
 @stop
