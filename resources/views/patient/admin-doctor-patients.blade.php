@extends('layouts.main-layout')
@section('title', "View Patients")
@section('body')
    <div class="tw-px-10 sm:tw-px-20 lg:tw-px-40">
        @include('partials.success')
        @include('partials.errors')
        <h2>Patients:</h2>
        <div>
            <div class="container">
                <table id="patient-tables" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>IC</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th data-sortable="false">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $patient['name'] }}</td>
                            <td>{{ $patient['email'] }}</td>
                            <td>{{ $patient['ic'] }}</td>
                            <td>{{ $patient['gender'] }}</td>
                            <td>{{ $patient['phone'] }}</td>
                            <td class="tw-flex tw-justify-around">
                                <a href="{{route('patient.show', $patient['id'])}}" class="btn btn-primary btn-sm">View</a>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="deletePatient(`patients/{{$patient['id']}}`,`{{$patient['name']}}`)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('partials.modal.delete')
@endsection
@section('script')
    <script>

        $(document).ready(function () {
            $('#patient-tables').DataTable();
        });

        function deletePatient(path, name) {
            deleteModal({
                title: 'Delete patient record',
                message: "Are you sure to delete patient <span class='tw-text-highlight-blue'>" + name + "</span> ?",
                action: path
            })
        }

    </script>
@stop

