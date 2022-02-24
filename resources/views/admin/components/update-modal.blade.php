<style>
  .timeslot {
  background-color: #00c09d;
  width:80px;
  height: 40px;
  color: white;
  padding:2px;
  margin: 5px 5px;
  font-size: 14px;
  border-radius: 3px;
  vertical-align: center;
  text-align:center;
}

.timeslot:hover { 
  background-color: #2CA893;
  cursor: pointer;
}

</style>
<body>
    <div class="modal fade" id="updateAppointmentModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ $modalTitle }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container mt-5" style="max-width: 450px">
                  <form action="">
                    <div class="form-group">
                      <label for="apptDate">New Appointment Date:</label>
                      <input type='date' class="form-control" id="apptDate"/>
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                   </div>
                   <label for="timeslot">Timeslot:</label>
  
                   <div class="form-group d-flex flex-row  flex-wrap justify-content-center">
                     @foreach (config('variables.TIMESLOT_STRINGS') as $timeslot)
                     <div class="timeslot">{{ $timeslot }}</div>
                     @endforeach
                   </div>
                  </form>
                   
               </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Yes</button>
            </div>
          </div>
        </div>
      </div>
    

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
  $(function(){
      var dtToday = new Date();
      
      var month = dtToday.getMonth() + 1;
      var day = dtToday.getDate();
      var year = dtToday.getFullYear();
      if(month < 10)
          month = '0' + month.toString();
      if(day < 10)
          day = '0' + day.toString();
      
      var maxDate = year + '-' + month + '-' + day;

      $('#apptDate').attr('min', maxDate);
  });
</script>    
