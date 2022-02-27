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
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                @can('patient-access')
                    <li class="nav-item">
                        <a class="nav-link" href="/patient/main">Appointments</a>
                    </li>
                @endauth
                @can('admin-access')
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/appointment">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('patient.index')}}">Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Doctors</a>
                    </li>
                @endcan
                @can('doctor-access')
                    <li class="nav-item">
                        <a class="nav-link" href="#">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('patient.index')}}">Patients</a>
                    </li>
                @endcan
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('profile')}}">{{\Illuminate\Support\Facades\Auth::user()->name}}
                    </a>
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
