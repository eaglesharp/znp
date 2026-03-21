{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

<form class="form" id="verifications1" method="POST" action="{{ route('update.profile.verifications', [$user->id]) }}" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-body">

        

        {{-- <div class="form-group" id="div_recruiter_verified">

            <label for="recruiter_verified" class="bold">User Verified </label>

            <select name="recruiter_verified" id="recruiter_verified" class="form-control">

                <option   value="1" @if(isset($user)) @if($user->recruiter_verified=="1") selected @endif  @endif>Yes</option>

                <option  value="0" @if(isset($user)) @if($user->recruiter_verified=="0") selected @endif  @endif>No</option>

              

            </select>

            

            <span class="help-block verified-error"></span> 

        </div> --}}

        <div class="form-group" id="div_recruiter_comments">

            <label for="recruiter_comments" class="bold">Recruiter Comments <span class="text-danger">*</span></label>

            <textarea name="recruiter_comments" class="form-control newtest" id="recruiter_comments" placeholder="Recruiter Comments">{{ old('recruiter_comments', (isset($user))? $user->recruiter_comments:'') }}</textarea>

            <span class="help-block recruiter_comments-error"></span>
         </div>

         <div class="form-group" id="div_recruiter_email">

            <label for="recruiter_email" class="bold">Recruiter Email <span class="text-danger">*</span></label>

            <input type="text" name="recruiter_email" class="form-control newtest" id="recruiter_email" placeholder="Recruiter Email" value="{{ old('recruiter_email', (isset($user))? $user->recruiter_email:'') }}">

            <span class="help-block recruiter_email-error"></span>
         </div>
         <div class="form-group" id="div_recruiter_phone">

            <label for="recruiter_phone" class="bold">Recruiter Phone <span class="text-danger">*</span></label>

            <input type="text" name="recruiter_phone" class="form-control newtest" id="recruiter_phone" placeholder="Recruiter Phone" value="{{ old('recruiter_phone', (isset($user))? $user->recruiter_phone:'') }}">

            <span class="help-block recruiter_phone-error"></span>
         </div>

         <div class="form-group" id="div_recorded_video">

            <label for="recorded_video" class="bold">Recorded Video Interview <span class="text-danger">*</span></label>

            <input type="file" name="recorded_video" class="form-control newtest" id="recorded_video" placeholder="recorded_video" value="">

            @isset($user)
            <span>
                {{ $user->recorded_video }}
            </span>
            @endisset

            <span class="help-block recorded_video-error"></span>
         </div>


        <button type="button" class="btn btn-large btn-primary" onClick="submitVerifications();">Update Comments <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

    </div>

    <div id="success_msg8" class="has-error"></div>

</form>

@push('scripts') 

<script type="text/javascript">

    function submitVerifications() {

   

       var form = $('#verifications1');
        var formData = new FormData(form[0]); // Create a FormData object

        $.ajax({

            url: form.attr('action'),

            type: form.attr('method'),

            data: formData, // Use the FormData object
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting content type

     

            dataType: 'json',

            success: function (json) {

                $(".help-block").hide(); 

                $("#success_msg8").show();

                $(".newtest").css("border-color","#ccc ");

                // alert('success');

                console.log("test");

                 $("#success_msg8").html('<span class="text text-success">Recruiter Comments updated successfully</span>');

                 setTimeout(function() { $("#success_msg8").hide(); }, 5000);

            },

            error: function (json) {

            

                if (json.status === 422) {

                    var resJSON = json.responseJSON;
                    $(".help-block").show(); 

                    $('.help-block').html('');

                    $.each(resJSON.errors, function (key, value) {

                        $('.' + key + '-error').html('<strong>' + value + '</strong>');

                        $('#div_' + key).addClass('has-error');

                    });

                } else {

                    console.log(json.responseJSON);

                    // Error

                    // Incorrect credentials

                    alert('Incorrect credentials. Please try again.')

                }

            }

        });

    }

</script>

@endpush