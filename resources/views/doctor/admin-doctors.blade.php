@extends('layouts.main-layout')
@section('body')
<div class="tw-px-10 sm:tw-px-20 lg:tw-px-40">
    <h1>Admin Dashboard</h1>
</div>

<div class="row">
    <div class="col-lg-11 mx-auto">
        <div class="card border-0">
            <div class="card-body p-3">
                <h2>Doctors </h2>
                <br>
                {{-- <div class="input-group col-md-0">
                    <form class="d-flex">
                        <input class="form-control mr-0" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                        <button class="btn btn-outline-primary tw-float-right" type="button" data-toggle="tooltip" data-placement="top" title="Add">
                            <i class="fa fa-plus"></i>
                        </button>
                    </form>
                </div> --}}
                <div class="row">
                    <div class="col-4">
                        <form class="d-flex">
                            <input class="form-control mr-0" type="search" placeholder="Search" aria-label="Search">
                        </form>
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
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Expertise</th>
                                <th scope="col">Remarks</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Dr. Ulrike Herx</td>
                                <td>General & Internal Medicine</td>
                                <td>lalalalalalalalalalalalalalalalalala</td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                        </li>
                                        <li class="list-inline-item">
                                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Dr. Ulrike Herx</td>
                                <td>General & Internal Medicine</td>
                                <td></td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                        </li>
                                        <li class="list-inline-item">
                                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Dr. Ulrike Herx</td>
                                <td>General & Internal Medicine</td>
                                <td></td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                        </li>
                                        <li class="list-inline-item">
                                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Dr. Ulrike Herx</td>
                                <td>General & Internal Medicine</td>
                                <td></td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                        </li>
                                        <li class="list-inline-item">
                                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
@stop
