<form class="form" id="add_edit_interview" method="POST" action="{{ route('store.video.interview',$user->id) }}">

    {{ csrf_field() }}



    <div class="modal-body">

        {{-- <div class="row">
            <div class="col-lg position_lit notice-period">

                <select id="select_for_interview" class="form_control form_action rounded pl-3 pr-5"
                    name="video_interview">

                    <option selected disabled>Choose Video Interview</option>

                    <option value="1" @if(isset($user->video_interview)) @if($user->video_interview=="1") selected @endif  @endif>
                        Anytime</option>

                    <option value="2" @if(isset($user->video_interview)) @if($user->video_interview=="2") selected @endif  @endif>
                        Specific Timings</option>

                </select>

            </div>
        </div> --}}




        <div class="row pt-3" >
            <div class="col-lg-6">

                <div class="form-group" id="div_video_date_from">

                <label class="mb-2 sign_fontsize">Date<span

                        class="text-danger px-1">*</span></label>

                <input type="text" name="date"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize date-picker" id="front_video_from" >

                    <span class="help-block date-error" style="color:#a94442"></span> 

                 <input type="hidden" name="user_id" value="{{$user->id}}"  >

                </div>

            </div>

         
            <div class="col-lg-6">

                <div class="form-group" id="div_from_time">

                <label class="mb-2 pt-3 pt-lg-0 sign_fontsize">From Time<span

                        class="text-danger px-1">*</span></label>

                <input type="text" name="from_time"

                    

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize"  id="input_from">

                    <span class="help-block from_time-error" style="color:#a94442"></span> 

                </div>

            </div>
            
             <div class="col-lg-6">

                <div class="form-group" id="div_to_time">

                <label class="mb-2 pt-3 pt-lg-0 sign_fontsize">To Time<span

                        class="text-danger px-1">*</span></label>

                <input type="text" name="to_time"

                    

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize" id="input_to">

                    <span class="help-block to_time-error" style="color:#a94442"></span> 

                </div>

            </div>


        </div>



    </div>

    <p id="success_id7" class="p-success px-0"></p>
    <!-- footer -->

    <div class="modal-footer">

        <div class="col-12 text-right">

            <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2" data-dismiss="modal">Cancel</button>

            <button type="submit" class="signin_button  px-3 py-1 rounded" data-toggle="modal" data-target="#create"
                onclick="submitVideoInterviewForm();">Save</button>

        </div>

    </div>

</form>

