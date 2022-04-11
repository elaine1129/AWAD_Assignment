@extends('layouts.main-layout')
@section('body')
<div class="tw-px-10 sm:tw-px-20 lg:tw-px-40">

  <p>Welcome Back!</p>
  <p>{{$patient['name']}}</p>
  {{-- section1-Appointments: Upcoming(pop up edit, with cancel button popup confirmation)| pending | completed. --}}
  <h2>Appointments:</h2>
  <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">Upcoming</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">Completed</a>
      </li>
    </ul>
    {{-- Upcoming tab--}}
    <div class="tab-content tw-mb-20" id="myTabContent">
      <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
        {{-- List of appointments   --}}
        <div>
          {{-- Each appointment --}}
          @foreach ($appointments_upcoming as $appointment )
            @foreach ($doctors as $doctor )
            @if($appointment['doctor_id'] == $doctor['id'])  
              <div  class="tw-shadow-sm tw-shadow-primary tw-rounded-lg tw-my-5 tw-mx-10 tw-p-5 row">
                <div class="col-md-9 tw-flex tw-flex-col">
                  <span class=" tw-text-lg tw-font-bold">{{$appointment['datecalendar']}} ({{$appointment['time']}})</span>
                  <span class=" tw-text-base">{{$doctor['name']}}</span>
                  <span class=" tw-text-sm">Condition: {{$appointment['condition']}}</span>
                </div>
                <div class="col-md-3 tw-text-center">
                  <span class="iconify" type="button" data-icon="fluent:delete-28-regular"
                  style="color: red;"  onclick="deleteAppointment(`/patient/appointment/{{ $appointment['id'] }}/delete`)"></span>
                </div>
              </div>
              @endif
            @endforeach

          @endforeach
        </div>
        
      </div>
      {{-- Pending tab--}}
      <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
       
        {{-- List of appointments   --}}
        <div>
          {{-- Each appointment --}}
            @foreach ($appointments_pending as $appointment )
            @foreach ($doctors as $doctor )
            @if($appointment['doctor_id'] == $doctor['id'])  
              <div  class="tw-shadow-sm tw-shadow-primary tw-rounded-lg tw-my-5 tw-mx-10 tw-p-5 row">
                <div class="col-md-9 tw-flex tw-flex-col">
                  <span class=" tw-text-lg tw-font-bold">{{$appointment['datecalendar']}} ({{$appointment['time']}})</span>
                  <span class=" tw-text-base">{{$doctor['name']}}</span>
                  <span class=" tw-text-sm">Condition: {{$appointment['condition']}}</span>
                </div>
                <div class="col-md-3 tw-text-center">
                  <span class="iconify" type="button" data-icon="bytesize:edit"
                style="color: rgb(151, 149, 149);" data-toggle="modal"
                data-target="#updateAppointmentModal"
                onclick="updateAppointment(`/patient/appointment/{{ $appointment['id'] }}`, {{ $appointment }})"></span>
                  <span class="iconify" type="button" data-icon="fluent:delete-28-regular"
                  style="color: red;"  onclick="deleteAppointment(`/patient/appointment/{{ $appointment['id'] }}/delete`)"></span>
                </div>
              </div>
              @endif
            @endforeach

          @endforeach
          
        </div>

      </div>
      {{-- Completed tab--}}
      <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
       {{-- List of appointments   --}}
       <div>
        {{-- Each appointment --}}
          @foreach ($appointments_completed as $appointment )
          @foreach ($doctors as $doctor )
          @if($appointment['doctor_id'] == $doctor['id'])  
            <div  class="tw-shadow-sm tw-shadow-primary tw-rounded-lg tw-my-5 tw-mx-10 tw-p-5 row">
              <div class="col-md-9 tw-flex tw-flex-col">
                <span class=" tw-text-lg tw-font-bold">{{$appointment['datecalendar']}} ({{$appointment['time']}})</span>
                <span class=" tw-text-base">{{$doctor['name']}}</span>
                <span class=" tw-text-sm">Condition: {{$appointment['condition']}}</span>
              </div>
              
            </div>
            @endif
          @endforeach

        @endforeach
        
      </div>
        
      </div>
    </div>
    {{-- section2-OurDoctors: --}}
    <h2>Our Doctors: </h2>
    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-3 tw-gap-x-8 tw-gap-y-3">
        @foreach($doctors as $doctor)
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="tw-w-32">
                                <img class="tw-w-full rounded-circle" src="{{$doctor->imageUrl()}}" alt="user profile">
                            </div>
                            <h5 class="card-title">{{$doctor->name}}</h5>
                            <p class="card-text">Expertise: {{$doctor->data['expertise']}}</p>
                            <a href="{{route('appointment.create', $doctor)}}" class="btn btn-primary">Make appointment</a>
                        </div>
                    </div>
                </div>
        @endforeach
    </div>
      
</body>
@include('partials.modal.confirm')
@include('partials.modal.delete')
@include('admin.components.update-modal')
@endsection
@section('script')
    <script>

        function deleteAppointment(path) {
            deleteModal({
                title: 'Delete Appointment',
                message: "Are you sure to delete this appointment",
                action: path
            })
        }

       
        function updateAppointment(path, data) {
            console.log(path)
            updateModal({
                title: 'Update Appointment',
                action: path,
                appointment: data
            })
        }
    </script>
@stop
