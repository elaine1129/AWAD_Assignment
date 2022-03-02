<!-- Modal -->
<div id="alert-container" class="tw-fixed tw-mx-auto tw-left-0 tw-right-0 tw-w-[85vw] md:tw-w-[70vw] tw-top-[4.75rem] tw-z-50 tw-hidden">
    <div id="alert-modal" class="alert alert-dismissible fade tw-shadow-md" role="alert" data-alert-message="{{json_encode(Session::get('alert'))}}">
        <strong id="alert-type"></strong> <span id="alert-message">You should check in on some of those fields below.</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@push('child-script')
    <script>
        const alert = {
            info: {
                className: 'alert-info',
                msgType: 'INFO',
            },
            warning: {
                className: 'alert-warning',
                msgType: 'WARNING',
            },
            success: {
                className: 'alert-success',
                msgType: 'SUCCESS',
            },
            danger: {
                className: 'alert-danger',
                msgType: 'DANGER',
            },
        }
        let alertElem = $('#alert-modal')
        function alertModal({message, type = 'info', timeout = 3000}){
            const {msgType, className} = alert[type];

            $('#alert-modal #alert-type').html(msgType)
            if(message) $('#alert-modal #alert-message').html(message)
            toggleAlert(className, timeout)
        }

        function toggleAlert(className = 'alert-info', timeout = 3000){
            alertElem.addClass(className)
            alertElem.toggleClass('show')
            $('#alert-container').toggleClass('tw-hidden')

            if(timeout){
                setTimeout(() => {
                    alertElem.toggleClass('show')
                }, timeout)
            }
        }

        // auto display alert if session is set
        // ex:
        // return redirect()->back()->with('alert', [
        //     'message'=>'403 You are not allowed to perform this action.',
        //     'type'=>'danger',
        // ]);
        let sessionAlert = alertElem.data('alert-message');
        if(sessionAlert){
            alertModal({
                message: sessionAlert.message,
                type: sessionAlert.type,
                timeout: sessionAlert.timeout,
            })
        }

    </script>
@endpush
