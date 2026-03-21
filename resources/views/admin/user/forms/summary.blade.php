{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')
<style>
    #div_latestcom .select2-container {
        width: 100% !important;
    }
</style>
<form class="form" id="add_edit_profile_summary" method="POST" action="{{ route('update.profile.summary', [$user->id]) }}">{{ csrf_field() }}

    <div class="form-body">

        

        <div class="form-group " id="div_summary">

            <label for="summary" class="bold">Profile Summary</label><span class="text-danger px-1">*</span>

            <textarea name="summary" class="form-control newtest" id="summary" placeholder="Profile Summary">{{ old('summary', (isset($user))? $user->getProfileSummary('summary'):'') }}</textarea>

            <span class="help-block summary-error"></span>
        </div>

            

            

            <label for="totalexp" class="bold">Total Experience</label><span class="text-danger px-1">*</span>

            <div class="row">

                <div class="form-group col-lg-6" id="div_totalexp">


                    <?php 


                    $exp=(isset($user->getsummaries()->totalexp) ? $user->getsummaries()->totalexp:'');



                    ?>               

                    {!! Form::select('totalexp',[''=>'Select Year']+MiscHelper::gettotalexp(),$exp,array('class'=>'form-control newtest','id'=>'totalexp')  )  !!}      

         

                    {{-- <input name="totalexp" class="form-control" id="totalexp" placeholder="Profile Experience">{{ old('totalexp', (isset($user))? $user->getProfileSummary('totalexp'):'') }}</input> --}}

                    <span class="help-block totalexp-error"></span>
                </div>

                <div class="form-group col-lg-6" id="div_totalexpmonth">

                

                    <?php 

                    $month=(isset($user->getsummaries()->totalexpmonth) ?$user->getsummaries()->totalexpmonth :'');

                    ?>

                

                    {!! Form::select('totalexpmonth',[''=>'Select Month']+MiscHelper::getprofilemonths(),$month,array('class'=>'form-control newtest','id'=>'totalexpmonth')  )  !!}  

                    <span class="help-block totalexpmonth-error"></span>
                </div>

            </div>
                <!--   ------------------------------------------------------ -->

               

                <div class="row">

                    <div class="form-group col-lg-6" id="div_latestcom">

                        <label for="latestcom" class="bold">Latest Company</label><span class="text-danger px-1">*</span>

               

                            <?php 

                                    

                            $latestcom=(isset($user->getsummaries()->latestcom) ? $user->getsummaries()->latestcom:'');

                            

                            ?>               

                       

                       

                       

                        {{-- {!! Form::text('latestcom',$latestcom,array('class'=>'form-control newtest','id'=>'latestcom','placeholder'=>'Latest Company')  )  !!}       --}}
                                    @php
                                    $datas = DB::table('company_data')->select('id','name')->distinct()->get();
                                @endphp

                        <select name="latestcom" class="form-control newtest js-example-tags">
                            
                            @foreach ($datas as $c_data)
                            <option value="{{ $c_data->id }}"
                            @isset($user->getsummaries()->latestcom_id)                                    
                            
                            @if ($user->getsummaries()->latestcom_id == $c_data->id)
                                selected
                            @endif

                            @endisset
                            >{{ $c_data->name }}</option>
                            @endforeach                       
                        
                            </select>
                            

                                    {{-- <input name="totalexp" class="form-control" id="totalexp" placeholder="Profile Experience">{{ old('totalexp', (isset($user))? $user->getProfileSummary('totalexp'):'') }}</input> --}}

                                    <span class="help-block latestcom-error"></span>
                    </div>

                    <div class="form-group col-lg-6" id="div_latestdesg">

                        <label for="latestdesg" class="bold">Latest Designation</label><span class="text-danger px-1">*</span> 

                    

                        <?php 

                        $latestdesg=(isset($user->getsummaries()->latestdesg) ?$user->getsummaries()->latestdesg :'');

                        ?>

                    

                        {!! Form::text('latestdesg',$latestdesg,array('class'=>'form-control newtest','id'=>'latestdesg','placeholder'=>'Latest Designation')  )  !!}  

                        <span class="help-block latestdesg-error"></span> 

                    </div>

                </div>
                       
        @php
            $selected = [];
            $selected = unserialize($user->ignore_companies);
        @endphp
                <div class="row">
                       <div class="col-12 col-md-12 mt-3">

                    <label class="sign_fontsize ignore-i">Jobsearch Privacy: Please choose to hide your CV from being viewed by the Employers (Current/Past) <i class="fa fa-info"
                        data-toggle="tooltip" title="This is a privacy option. This wiill help you not be found by the employers (Current/Past) you choose to hide your CV from"></i></label>
                                    
                                <div class="w-100 ignore-class"  >
                                    <select class="form-control js-example-tags" id="ignore_companies" name="ignore_companies[]" multiple="multiple" style="width: 100%;">
                                
                                        @foreach ($datas as $c_data)
                                       <option value="{{ $c_data->id }}" @if(!is_null($selected) && is_array($selected) && in_array($c_data->id, $selected)) selected @endif>
                                            {{ $c_data->name }}
                                        </option>
                                    @endforeach                                                         
                                    </select>
                                
                                </div> 
                </div>      
          
                </div>

                <div class="row">

                        <div class="form-group col-md-6" id="div_currentshift">
                            <label for="currentshift" class="bold">Current Shift</label><span class="text-danger px-1">*</span>
                        

                            <select name="currentshift" id="currentshift" class="form-control newtest">

                                <option value="" selected disabled hidden>Select</option>

                                <option   value="Indian Shift" @if(isset($user->getsummaries()->currentshift)) @if($user->getsummaries()->currentshift=="Indian Shift") selected @endif  @endif >Indian Shift</option>                           

                                <option  value="US Shift"  @if(isset($user->getsummaries()->currentshift)) @if($user->getsummaries()->currentshift=="US Shift") selected @endif  @endif >US Shift</option>

                                <option  value="UK Shift" @if(isset($user->getsummaries()->currentshift)) @if($user->getsummaries()->currentshift=="UK Shift") selected @endif  @endif >UK Shift</option>

                                <option  value="Rotational" @if(isset($user->getsummaries()->currentshift)) @if($user->getsummaries()->currentshift=="Rotational") selected @endif  @endif >Rotational</option>

                            </select>


                                <span class="help-block currentshift-error"></span>
                            
                        </div>
                        
                        


                        <div class="form-group col-md-6" id="div_currentshift">
                                <label for="reason_moved" class="bold">Reason for moving out</label><span class="text-danger px-1">*</span>
                            
    
                                <select name="reason_moved" id="reason_moved" class="form-control newtest">
    
                                    <option value="" selected disabled hidden>Select</option>
        
                                    <option   value="Lay Offs" @if($user->reason_moved == 'Lay Offs')selected @endif>Lay Offs</option>
                
                                    <option  value="Resignation" @if($user->reason_moved == 'Resignation')selected @endif>Resignation</option>
                              
                                    <option  value="Fresher" @if($user->reason_moved == 'Fresher')selected @endif>NA - Fresher</option>
                
                                </select>
    
    
                                    <span class="help-block currentshift-error"></span>
                                
                            </div>

                    <div class="col-md-12">
                        <button type="button" class="btn btn-large btn-primary" onClick="submitProfileSummaryForm();">Update Summary <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
                    </div>
                </div>
       
            </div>
    <div id="success_msg5" class="has-error"></div>

</form>

@push('scripts') 

<script type="text/javascript">

$(".js-example-tags").select2({
                            tags: true
                          });

    function submitProfileSummaryForm() {

        var form = $('#add_edit_profile_summary');

        $.ajax({

            url: form.attr('action'),

            type: form.attr('method'),

            data: form.serialize(),

            dataType: 'json',

            success: function (json) {
                $(".help-block").hide(); 

                $(".newtest").css("border-color","#ccc ");
                $("#success_msg5").html('<span class="text text-success">Summary updated successfully</span>');

                setTimeout(function() { $("#success_msg5").hide(); }, 5000);
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

                    // Error

                    // Incorrect credentials

                    // alert('Incorrect credentials. Please try again.')

                }

            }

        });

    }



    $("#totalexp option:first").attr("disabled", "disabled");
    $("#totalexpmonth option:first").attr("disabled", "disabled");
</script>

@endpush