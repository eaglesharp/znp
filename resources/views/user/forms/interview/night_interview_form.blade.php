

    <form class="form"  id="add_night_interview" method="POST" action="{{ route('store.night.interview',$user->id) }}">

        {{ csrf_field() }}

    <div class="modal-body" >



        <div class="row">

            <div class="col-lg-4">

                <div class="form-group" id="div_night_telephonic_date_from">

                <label class="mb-2  sign_fontsize">From<span class="text-danger px-1">

                    </span></label>

                <input type="text"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize night_date_from" name="night_telephonic_date_from" >

                    <span class="help-block night_telephonic_date_from-error" style="color:#a94442"></span> 

            </div>

        </div>

            <div class="col-lg-4">

                <div class="form-group" id="div_night_telephonic_date_to">

                <label class="mb-2  sign_fontsize">To<span class="text-danger px-1">

                    </span></label>

                <input type="text"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize night_date_to" name="night_telephonic_date_to">

                    <span class="help-block night_telephonic_date_to-error" style="color:#a94442"></span> 

            </div>

        </div>

            <div class="col-lg-4">

                <div class="form-group" id="div_night_time">

                <label class="mb-2 pt-3 pt-lg-0 sign_fontsize">Time<span

                        class="text-danger px-1"> </span></label>

                {{-- <input type="text" min="21:00" max="06:00" name="night_time" id="timepickers"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize"> --}}
                    {!! Form::select('night_time', ['' => 'Select ']+MiscHelper::gettime(),(isset($user->getprofileDetails()->night_time)), array('class'=>'w-100 signup_input rounded px-3 py-2 sign_fontsize', 'id'=>'night_time')) !!}
                   
                    <span class="help-block night_time-error" style="color:#a94442"></span> 

            </div>

        </div>

        </div>

    </div>

    <p id="success_id6"  class="p-success px-0"></p>

    <!-- footer -->

    <div class="modal-footer">

        <div class="col-12 text-right">

            <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

                data-dismiss="modal">Cancel</button>

            <button type="submit" class="signin_button  px-3 py-1 rounded"

                data-toggle="modal" data-target="#create" onclick="submitnightInterviewForm();">Save</button>

        </div>

    </div>

</form>

@push('styles')
<style>
.ui-timepicker-viewport{
    z-index: 9999999;
    background: #ffff;
}

</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>

    

$(document).ready(function(){
   



   $('#timepickers').timepicker({
       timeFormat: 'h:mm p',
       interval: 60,
       minTime: '9',
       maxTime: '6:00pm',
       defaultTime: '',
       startTime: '9:00',
       dynamic: false,
       dropdown: true,
       scrollbar: true,
     
   });
   
   
   
   
   });
</script>
@endpush