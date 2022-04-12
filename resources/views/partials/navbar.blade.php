@auth
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">
            <span class="iconify tw-mb-1 tw-text-4xl" data-icon="uim:clinic-medical" data-inline="false"></span>
            {{config('clinic.app-name')}}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @can('patient-access')
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('patient.home')}}">Home</a>
                    </li>
                @endauth
                @can('admin-access')
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin-appointment')}}">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('patient.index')}}">Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('doctor.index')}}">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('schedule.create')}}">Schedules</a>
                    </li>
                @endcan
                @can('doctor-access')
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('doctor-appointment')}}">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('patient.index')}}">Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Schedules</a>
                    </li>
                @endcan
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <div class="dropdown tw-mx-0 lg:tw-mx-5">
                        <a class="nav-link dropdown-toggle" href="#" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(\Illuminate\Support\Facades\Auth::user()->isDoctor())
                                <img class="tw-max-h-5 tw-rounded-full" src="{{\Illuminate\Support\Facades\Auth::user()['data']['image_url']}}" alt="">
                            @else
                                <span class="iconify tw-text-3xl tw-text-primary" data-icon="healthicons:ui-user-profile" data-inline="false"></span>
                            @endif
                            {{\Illuminate\Support\Facades\Auth::user()->name}}
                        </a>
                        <div class="dropdown-menu md:tw-mb-3 lg:tw-mb-0" aria-labelledby="dropdownMenuButton">
                            @can('patient-access')
                                <a class="dropdown-item" href="{{route('patient-profile.show')}}">View Profile</a>
                            @endcan
                            <a class="dropdown-item" href="{{route('common.show-profile')}}">Edit Profile</a>
                            <a class="dropdown-item" href="{{route('common.show-password')}}">Change Password</a>
                        </div>
                    </div>
                </li>
                <a class="btn btn-danger my-2 my-sm-0 nav-item" href="{{route('logout')}}">Logout</a>
            </ul>
        </div>
    </nav>

    @push('child-script')
        <script>
            let currentUrl = '{{Request::url() }}'
            $('.nav-link').each(function (){
                if($(this).attr('href') == currentUrl){
                    $(this).addClass('active');
                }
            })
        </script>
    @endpush
@endauth
