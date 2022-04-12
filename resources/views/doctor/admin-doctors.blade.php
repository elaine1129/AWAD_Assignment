@extends('layouts.main-layout')
@section('body')

<div class="row">
    <div class="col-lg-11 mx-auto">
        <div class="card border-0">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-4">
                        <h2>Doctors List</h2>
                        <br>
                    </div>
                    <div class="col-7"></div>
                    <div class="col">
                        <a class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="top" title="Add" href="{{route('register-doctor')}}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>

                <!-- Responsive table -->
                <div class="table-responsive">
                    <table class="table m-0" id="doctors-list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Expertise</th>
                                <th data-sortable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctors as $doctor)
                              <tr id={{ $doctor['id'] }}>
                                <td class="index"></td>
                                <td>{{ $doctor['name'] }}</td>
                                <td>{{ $doctor['email'] }}</td>
                                <td>{{ $doctor['data']['expertise'] }}</td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <a class="tw-text-white hover:tw-text-gray-300" href={{ "doctors/".$doctor['id']."/edit" }}><i class="fa fa-edit"></i></a>
                                            </button>
                                        </li>
                                        <li class="list-inline-item">
                                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteDoctor(this)">
                                                <i class="hover:tw-text-gray-300 fa fa-trash"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>   
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@include('partials.modal.delete')
@section('script')
<script>
     $(document).ready(function () {
            let doctorTable = $('#doctors-list').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [[1, 'asc']]
            });

            doctorTable.on('order.dt search.dt', function () {
                doctorTable.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });

        function deleteDoctor(row){
            let id = $(row).parent().parent().parent().parent().attr('id')
            let name = $(row).parent().parent().parent().parent().children('td').eq(1).html();
            let path = '/admin/doctors/' + id;
             deleteModal({
                title: 'Delete doctor',
                message: "Are you sure to delete doctor <span class='tw-text-highlight-blue'>" + name + "</span> ?",
                action: path
            })
        }

</script>
@stop
