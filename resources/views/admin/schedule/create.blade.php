@extends('layouts.main-layout')
@section('body')
    <div class="container">
        <div class="row tw-mt-5">
            <div class="col-md-12">
                <h3>Schedules <small>» Generate schedules</small></h3>
            </div>
            <div class="mx-auto">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Schedules</h3></div>
                    <div class="card-body">
                        <div class="tw-flex tw-justify-between tw-mb-3 tw-text-gray-500 tw-flex-column md:tw-flex-row">
                        </div>
                        @include('partials.errors')
                        @include('partials.success')
                        <form role="form" method="POST" action="{{route('schedule.store')}}" id="schedules-form">
                            @csrf

                            <div class="form-group row">
                                <label for="from-date-picker" class="col-md-3 col-form-label">From (Start Date*)</label>
                                <div class="col-md-9">
                                    <input id="from-date-picker" class="form-control" name="from"
                                           value="{{old($from, '')}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to-date-picker" class="col-md-3 col-form-label">To (End Date*)</label>
                                <div class="col-md-9">
                                    <input disabled id="to-date-picker" class="form-control" name="to"
                                           value="{{old($to, '')}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="prescription" class="col-md-12 col-form-label">Create for doctor:</label>
                                <div class="col-md-12">
                                    <table id="doctor-list" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th data-sortable="false" onclick="selectAll(this)"
                                                class="tw-cursor-pointer">Select All
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($doctors as $doctor)
                                            <tr>
                                                <td>{{ $doctor['id']}}</td>
                                                <td>{{ $doctor['name']  }}</td>
                                                <td class="tw-p-0">
                                                    <label
                                                        class="tw-cursor-pointer tw-flex tw-items-center tw-justify-center tw-h-full tw-w-full">
                                                        <input class="form-check-input position-static" type="checkbox"
                                                               name="doctor_ids[]" value="{{$doctor['id']}}"
                                                               @if(is_array($doctor_ids) and in_array($doctor['id'],old('doctor_ids',[]))) checked="checked" @endif>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-7">
                                    <button type="submit" class="btn btn-primary btn-lg">Generate Schedules</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            let doctorTable = $('#doctor-list').DataTable();
            $('#from-date-picker').datepicker({
                minDate: 0, maxDate: "+1M", onSelect(val) {
                    $('#to-date-picker').datepicker({
                        minDate: new Date(val),
                        maxDate: '+1M',
                    });
                    $('#to-date-picker').val(val)
                    $('#to-date-picker').prop('disabled', false);
                }
            });
        });

        function selectAll(elem) {
            let desc = elem.innerHTML
            $('input[type=checkbox]').prop('checked', desc === 'Select All');
            elem.innerHTML = desc === 'Select All' ? 'Deselect All' : 'Select All';
        }
    </script>
@endsection

