<!-- Modal -->
<div class="modal fade" id="delete-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-desc">
            </div>
            <div class="modal-footer">

                {{--            ACTION TO BE SET DYNAMICALLY--}}
                <form action="" METHOD="POST" id="modal-delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('child-script')
    <script>
        function deleteModal({title, message, action, callback = () => $('#modal-delete-form').submit()}){
            if(title) $('#delete-modal .modal-desc').html(message)
            if(message) $('#delete-modal .modal-title').html(title)
            if(action) $('#delete-modal #modal-delete-form').attr('action', action)

            $('#delete-modal').modal().show()
            $('#delete-modal .btn-delete').off().on('click', function() {
                // close window
                $('#delete-modal').modal('hide');

                // and callback
                callback();
            });
        }

    </script>
@endpush
