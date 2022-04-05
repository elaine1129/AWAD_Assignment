<style>
    .timeslot {
        background-color: #00c09d;
        width: 80px;
        height: 40px;
        color: white;
        padding: 2px;
        margin: 5px 5px;
        font-size: 14px;
        border-radius: 3px;
        vertical-align: center;
        text-align: center;
    }

    .timeslot:hover {
        background-color: #2CA893;
        cursor: pointer;
    }

    .timeslot: {
        background-color: red;
    }

</style>

<body>
    <div class="modal fade" id="updateAppointmentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">=</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-desc">
                    <div class="container mt-5" style="max-width: 450px">
                        <form action="" method="POST" id="modal-update-form">
                            @csrf
                            <div class="form-group">
                                <label for="apptDate">New Appointment Date:</label>
                                <input type='date' class="form-control" id="apptDate" name="apptDate"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="timeslot">New Appointment Time Slot:</label>
                                <select class="form-select" id="timeslot" name="timeslot">
                                    @foreach (config('variables.TIMESLOT_STRINGS') as $timeslot)
                                        <option value="{{ $loop->index }}">
                                            {{ $timeslot }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-yes">Yes</button>

                </div>
            </div>
        </div>
    </div>


</body>
@push('child-script')
    <script type="text/javascript">
        $(function() {
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;

            $('#apptDate').attr('min', maxDate);
        });

        function updateModal({
            title,
            action,
            appointment,
            callback = () => $('#modal-update-form').submit()
        }) {
            let updateModal = $('#updateAppointmentModal')
            if (title) updateModal.find('.modal-title').html(title)
            if (action) $('#updateAppointmentModal #modal-update-form').attr('action', action)
            updateModal.find('select').children().each(function() {
                if (this.value == appointment.timeslot) {
                    this.selected = true
                }
            })
            $('#apptDate').val(appointment.datecalendar)


            updateModal.modal().show()
            updateModal.find('.btn-yes').off().on('click', function() {
                // close window
                updateModal.modal('hide');
                console.log('Before callback', callback());

                // and callback
                callback();
                console.log('Done update', callback());

            });
        }
    </script>
@endpush
