<!-- Modal -->
<div class="modal fade" id="confirm-modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title modal-label"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body modal-desc">
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
        function confirmModal({callback, title = '', message}){
            let confirmElem = $('#confirm-modal')
            if(title) confirmElem.find('.modal-title').html(title)
            if(message) confirmElem.find('.modal-desc').html(message)

            confirmElem.modal().show()
            confirmElem.find('.btn-yes').off().on('click', function() {
                // close window
                confirmElem.modal('hide');

                // and callback
                callback();
            });
        }

    </script>
@endpush
