<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="modal-body">

    <div class="form-body">

        <input type="hidden" name="user_id" value="{{$user->id}}"  >

        
        <input type="hidden" value="{{$interview_id??''}}" name="interview_id">   

       
                <div class="form-group col-lg-12" id="div_date">

                    <label class="mb-2 pt-2 sign_fontsize">Date<span

                        class="text-danger px-1"> *</span></label>
    

                    <input type="text" name="date"

                    class="form-control date-picker" id="front_video_from" value="{{ \Carbon\Carbon::parse($interview->date)->format('d-m-Y')}}">

                   <span class="help-block date-error"></span> 

                </div>
                
                <div class="form-group col-lg-6" id="div_from_time">

                    <label class="mb-2 pt-2 sign_fontsize ">From Time<span

                        class="text-danger px-1"> *</span></label>
    

                    <input type="text" name="from_time"

                    class="form-control timepicker" id="input_from" value="{{ $interview->from_time??'' }} ">

                   <span class="help-block from_time-error"></span> 

                </div>

                <div class="form-group col-lg-6" id="div_to_time">

                    <label class="mb-2 pt-2 sign_fontsize ">To Time<span

                        class="text-danger px-1"> *</span></label>
    

                    <input type="text" name="to_time"

                    class="form-control timepicker" id="input_to" value="{{ $interview->to_time??'' }}">

                   <span class="help-block to_time-error"></span> 

                </div>



    </div>

</div>

<script type=text/javascript>



$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

});



  </script>



