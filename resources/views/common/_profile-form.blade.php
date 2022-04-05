@if (Route::is('doctor.edit'))
    @can('admin-access')
    <div class="label">
        <label for="name"> Expertise: </label>
    </div>
    <div class="input">
        <input style="width:35%" type="text" placeholder="expertise" name="expertise" required value="{{$expertise ?? ''}}">
    </div>

    <div class="label">
        <label for="name"> Profile image: </label>
    </div>
    <div class="input">
        <img id="image-preview" src="{{ url('/').'/'.$image_url ?? ''}}" alt="">
        <input type="file" name="image" id="image" onchange="previewFile(this);" >
    </div>

    @push('child-script')
        <script>
            function previewFile(input){
               let file = $(input).get(0).files[0]
               if(file){
                 let reader = new FileReader();
                 reader.onload = () => {
                     $('#image-preview').attr('src', reader.result);
                 }
                 reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush
    @endcan
@endif

@can('doctor-access')
<div class="label">
    <label for="name"> Expertise: </label>
</div>
<div class="input">
    <input style="width:35%" type="text" placeholder="expertise" name="expertise" required value="{{$expertise ?? ''}}">
</div>

<div class="label">
    <label for="name"> Profile image: </label>
</div>
<div class="input">
    <img id="image-preview" src="{{$image_url ?? ''}}" alt="">
    <input type="file" name="image" id="image" onchange="previewFile(this);" >
</div>

    @push('child-script')
        <script>
            function previewFile(input){
               let file = $(input).get(0).files[0]
               if(file){
                 let reader = new FileReader();
                 reader.onload = () => {
                     $('#image-preview').attr('src', reader.result);
                 }
                 reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush
@endcan

@can('patient-access')
    <div class="label">
        <label for="name"> Phone: </label>
    </div>
    <div class="input">
        <input style="width:35%" type="text" placeholder="expertise" name="phone" value="{{$phone ?? ''}}">
    </div>

    <div class="label">
        <label for="name"> IC: </label>
    </div>
    <div class="input">
        <input style="width:35%" type="text" placeholder="expertise" name="ic" value="{{$ic ?? ''}}">
    </div>


    <div class="label">
        <label for="name"> Gender: </label>
    </div>
    <div class="input">
        <input style="width:35%" type="text" placeholder="expertise" name="gender" value="{{$gender ?? ''}}">
    </div>

    <div class="label">
        <label for="name"> Address: </label>
    </div>
    <div class="input">
        <textarea style="width:35%" type="text" placeholder="expertise" name="address" rows="3">{{$address ?? ''}}</textarea>
    </div>
@endcan
