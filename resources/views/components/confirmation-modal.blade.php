<!-- Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ $modalTitle }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalDesc">
          {{ $modalDesc }}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-no" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary btn-yes">Yes</button>
        </div>
      </div>
    </div>
  </div>
@push('child-script')
    <script>
        function confirmModal(callback, title, message){
            if(title) $('#approveModal #modalDesc').html(message)
            if(message) $('#approveModal .modal-title').html(title)

            $('#approveModal').modal().show()
            $('#approveModal .btn-yes').off().on('click', function() {
                // close window
                $('#approveModal').modal('hide');

                // and callback
                callback();
            });
        }

    </script>
@endpush
