

    <form class="form"  id="edit_night_interview" method="POST" action="{{ route('update.night.interview',$user->id) }}">

        {{ csrf_field() }}

    <div class="modal-body" >



        <div class="row">

            <div class="col-lg-4">

                <div class="form-group" id="div_night_telephonic_date_from">

                <label class="mb-2  sign_fontsize">From<span class="text-danger px-1">

                    </span></label>

                <input type="text"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize " name="night_telephonic_date_from" value="{{ old('night_telephonic_date_from', (isset($user->getprofileDetails()->night_telephonic_date_from))? \Carbon\Carbon::parse($user->getprofileDetails()->night_telephonic_date_from)->format('d-m-Y'):'') }}" id="night_telephonic_date_from123">

                    <span class="help-block night_telephonic_date_from-error" style="color:#a94442"></span> 

                    <input type="hidden" name="user_id" value="{{$user->id}}">

            </div>

        </div>

            <div class="col-lg-4">

                <div class="form-group" id="div_night_telephonic_date_to">

                <label class="mb-2  sign_fontsize">To<span class="text-danger px-1">

                    </span></label>

                <input type="text"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize " name="night_telephonic_date_to" value="{{ old('night_telephonic_date_to', (isset($user->getprofileDetails()->night_telephonic_date_to))? \Carbon\Carbon::parse($user->getprofileDetails()->night_telephonic_date_to)->format('d-m-Y'):'') }}" id="night_telephonic_date_to123">

                    <span class="help-block night_telephonic_date_to-error" style="color:#a94442"></span> 

            </div>

        </div>

            <div class="col-lg-4">

                <div class="form-group" id="div_night_time">

                <label class="mb-2 pt-3 pt-lg-0 sign_fontsize">Time<span

                        class="text-danger px-1"> </span></label>
                        {!! Form::select('night_time', ['' => 'Select ']+MiscHelper::gettime(),(isset($user->getprofileDetails()->night_time)), array('class'=>'w-100 signup_input rounded px-3 py-2 sign_fontsize', 'id'=>'night_time')) !!}

                {{-- <input type="text"   min="21:00" max="06:00" name="night_time" value="{{ old('night_telephonic_time', (isset($user->getprofileDetails()->night_time))? $user->getprofileDetails()->night_time:'') }}"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize timepicker" id="timepicker">

                     --}}
                    <span class="help-block night_time-error" style="color:#a94442"></span> 

            </div>

        </div>

        </div>

    </div>

    <p id="success_id5"  class="p-success px-0"></p>

    <!-- footer -->

    <div class="modal-footer">

        <div class="col-12 text-right">

            <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

                data-dismiss="modal">Cancel</button>

            <button type="submit" class="signin_button  px-3 py-1 rounded"

                data-toggle="modal" data-target="#create" onclick="updatenightInterviewForm();">Save</button>

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
   
    $('#timepicker').timepicker({


        timeFormat: 'h:mm: p',
       //   minTime: '9',
     //  maxTime: '6',
    //     dynamic: false,
    //    dropdown: true,
    //    scrollbar: true,
        
         });



//    $('#timepicker').timepicker({
//        timeFormat: 'h:mm p',
//        interval: 60,
//        minTime: '9',
//        maxTime: '6:00pm',
//        defaultTime: '11',
//        startTime: '9:00',
//        dynamic: false,
//        dropdown: true,
//        scrollbar: true,
     
//    });
   
   
   
   
   });


$(document).ready(function () {





$('#night_telephonic_date_from123').datepicker({

    autoclose: true,

    format: 'dd-mm-yyyy',

    todayHighlight: true,

    startDate: '01/12/1950'

});

var startDate = new Date('01/12/1950');

var FromEndDate = new Date();

var ToEndDate = new Date();

ToEndDate.setDate(ToEndDate.getDate() + 365);



$('#night_telephonic_date_from123').datepicker({

    weekStart: 1,

    startDate: '18/09/1950',

    endDate: FromEndDate,

    autoclose: true

})

    .on('changeDate', function (selected) {

        startDate = new Date(selected.date.valueOf());

        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));

        $('#night_telephonic_date_to123').datepicker('setStartDate', startDate);

    });

$('#night_telephonic_date_to123')

    .datepicker({

        weekStart: 1,

        startDate: startDate,

        endDate: ToEndDate,

        format: 'dd-mm-yyyy',

        autoclose: true

    })

    .on('changeDate', function (selected) {

        FromEndDate = new Date(selected.date.valueOf());

        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));

        $('#night_telephonic_date_from123').datepicker('setEndDate', FromEndDate);

    });



});      



</script>
    
@endpush