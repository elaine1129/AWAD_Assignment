@extends('layouts.main-layout')
@section('body')
    <div class="container">
        <div class="row tw-mt-5">
            <div class="col-md-12">
                <h3>Book Appointment</h3>
            </div>
            <div class="col-md-12 col-lg-9 mx-auto">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Appointment</h3></div>
                    <div class="card-body">
                        @include('partials.errors')
                        @include('partials.success')
                        <form role="form" method="POST" action="{{route('appointment.store')}}">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{$doctor->id}}">

                            <div class="form-group">
                                <div>
                                    Selected Doctor:
                                </div>
                                <div class="tw-flex tw-items-center tw-gap-x-5">
                                    <img class="img-thumbnail tw-rounded-full tw-max-h-[6rem]" src="{{$doctor->data['image_url']}}" alt="">
                                    <div class="tw-text-gray-800 tw-text-xl">
                                        {{$doctor->name}}
                                        <div class="lead tw-text-sm">{{$doctor->data['expertise']}}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="condition" class="col-md-5 col-form-label">Condition</label>
                                <div class="col-md-12">
                                    <textarea rows="3" id="condition" class="form-control" name="condition">{{old('condition')}}</textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="schedule_id" class="col-md-3 col-form-label">Available
                                    Date:</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="schedule_id" id="schedule_id">
                                        <option value="" disabled selected>Please select a date</option>
                                    @foreach($doctor->schedulesAvailable() as $schedule )
                                            <option value="{{$schedule->id}}" @if(old('schedule_id') == $schedule->id) selected @endif>{{$schedule->date}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="timeslot" class="col-md-12 col-form-label">Select timeslots:</label>
                                <div class="col-md-12">
                                    <table id="timeslot-table" class="table table-bordered thead-light">
                                        <thead>
                                        <tr>
                                            <td>Time</td>
                                            <td>Select</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Models\Schedule::TIMESLOT_STRINGS as $index=>$timeslot)
                                            <tr>
                                                <td>{{$timeslot}}</td>
                                                <td>
                                                    <input type="radio" name="timeslot" value="{{$index}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2">Please select a date</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-7">
                                    <button type="submit" class="btn btn-primary btn-lg">Make Appointment
                                    </button>
                                    <button type="button" class="btn btn-light btn-lg" onclick="window.history.back()">Back</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let timeTable = $('#timeslot-table')
        let timeSelection = timeTable.find('tr:not(:last-child)');
        timeTable.find('tr:not(:last-child)').hide()
        function hideTimeSelection(){
            timeSelection.hide()
            timeTable.find('tr:last').show()
        }
        function showTimeSelection(){
            timeSelection.show()
            timeTable.find('tr:last').hide()
        }

        $('#schedule_id').on('change', async function () {
            hideTimeSelection();
            const res = await axios.post('/schedule/view-timeslot/'+ this.value)
            const data = await res.data
            if(data){
                showTimeSelection()
                timeSelection.each(function( index ) {
                    let input = $(this).find('input[type=radio]')
                    input.prop('checked', false)
                    input.prop('disabled', true)
                    if(data[index] == 1)
                        input.prop('disabled', false)
                })
            }else{
                timeTable.find('tr:last').html('No timeslots available for this date.')
            }
        })
        if($('#schedule_id').val() != ''){
            $('#schedule_id').trigger('change')
        }

    </script>
@endsection


