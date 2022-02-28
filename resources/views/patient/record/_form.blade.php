<div class="form-group row">
    <label for="symptoms" class="col-md-3 col-form-label">Symptoms*</label>
    <div class="col-md-9">
        <textarea class="form-control" name="symptoms" id="symptoms" rows="4">{{$symptoms}}</textarea>
    </div>
</div>

<div class="form-group row">
    <label for="diagnosis" class="col-md-3 col-form-label">Diagnosis*</label>
    <div class="col-md-9">
        <textarea class="form-control" name="diagnosis" id="diagnosis" rows="2">{{$diagnosis}}</textarea>
    </div>
</div>

<div class="form-group row">
    <label for="prescription" class="col-md-3 col-form-label">Prescription*</label>
    <div class="col-md-9">
        <textarea class="form-control" name="prescription" id="prescription" rows="4">{{$prescription}}</textarea>
    </div>
</div>

{{--<input name="appointment_id" id="appointment_id" type="hidden" value="{{$appointment_id}}">--}}

<div class="form-group row">
    <label for="prescription" class="col-md-12 col-form-label">Created for appointment (optional):</label>
    <div class="col-md-12">
        <table id="patient-appointments" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Date</th>
                <th>Visit Time</th>
                <th>Doctor</th>
                <th>Condition</th>
                <th>Status</th>
                <th data-sortable="false">Select</th>
            </tr>
            </thead>
            <tbody>
            @if(!is_null($patient['appointments']))
                @foreach ($patient->getDoneAppointment() as $appointment)
                    <tr>
                        <td>{{ $appointment['schedule'] ? \Carbon\Carbon::parse($patient['date'])->format(config('clinic.date_format')) : '-' }}</td>
                        <td>{{ $appointment['timeslot'] ? $appointment['time'] : '-' }}</td>
                        <td>{{  $appointment['doctor']['name'] }}</td>
                        <td class="two-lines-text">{{ $appointment['condition'] }}</td>
                        <td>{{ $appointment['status'] }}</td>
                        <td>
                            <label class="tw-flex tw-items-center tw-justify-center">
                                <input class="form-check-input position-static" type="checkbox" name="appointment_id" value="{{$appointment['id']}}" @if($appointment_id == $appointment['id']) checked="checked" @endif>
                            </label>
                        </td>
                    </tr>
            @endforeach
            @endif
            <tbody>
        </table>
    </div>
</div>

@push('append-scripts')
    <script>

    </script>
@endpush
