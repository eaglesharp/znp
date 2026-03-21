@extends('layouts.app')

@section('content') 

<!-- Header start --> 

@include('includes.header') 

<section class="section_mycollections">
    <div class="container">
        <div class="row">
            <div class="col-12 py-5">
                <div class="box py-4 py-md-5 px-3 px-md-5 rounded">
                   
                    <div class='alert alert-success newclass' id="myElem" style="display:none;">Updated Successfully</div>
                    <div class='alert alert-success newclass' id="myElem1" style="display:none;">Deleted Successfully</div>
                    <div class='alert alert-success newclass' id="myElem2" style="display:none;">Created Successfully</div>
                    <div class="" style="
                    display: flex;                  
                    justify-content: space-between;
                ">
                        <h5 class="px-4 my-0 text_box-align">Templates<span class="collect_twofont mb-2 ml-2">{{ $templates_count??'0' }}</span>
                        </h5>
                        <button type="button" 
                        class="signin_button px-4 py-2 emailsend rounded" onclick="createtemplate()">Create</button>  
                    </div>
                    <hr class="mt-1 mb-4">
                    <div class="row">
                      
                      @if(isset($templates) && count($templates) > 0)
                      @foreach ($templates as $template)
                          
                     
                        <div class="col-lg-3 col-md-6 mb-0 mb-md-3">
                           
                                <div class="collection_pic-box-template text-center mt-4 mt-md-0 px-0">
                                    <div class="collection_text">
                                        <div class="collections_text">{{ $template->templatename??'' }}</div>
                                        {{-- <div class="collections_font mx-auto">66</div> --}}
                                    </div>
                                </div>
                          
                            <div class="threedots float-right pr-4 pt-4 pt-lg-1">
                                <label class="dropdown">
                                    <i class="fa fa-ellipsis-v radio_point" aria-hidden="true"></i>
                                    <input type="checkbox" class="dd-input" id="test">
                                    <ul class="dd-menu">
                                        <li>
                                            <a class="py-2 px-3" onclick="viewtemplate({{ $template->id }})">
                                                View Template
                                            </a>
                                        </li>

                                        <li><a class="py-2 px-3" onclick="edittemplate({{ $template->id }})">Edit
                                                Template</a></li>

                                                {{-- <li><a class="py-2 px-3" data-toggle="modal" data-target="#editcollection">Edit
                                                    Collection</a></li>
                                                     --}}
                                        <li><a class="py-2 px-3" onclick="deletetemplate({{ $template->id }})" >Delete
                                                Template</a></li>
                                    </ul>
                                </label>
                            </div>
                        </div>
                        @endforeach
                        @endif
                       
                        {{-- <div class="col-lg-3 col-md-6">
                            <a href="javascript:void(0)" class="plus_collection" data-toggle="modal"
                                data-target="#create">
                                <div class="create_collection plus_collection px-0 mt-4 mt-md-0">
                                    +
                                </div>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <!-- modal -->
    <div class="modal fade" id="edittemplate" style="overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content mx-auto py-2">
                <!-- header -->
                <div class="modal-header pb-0">
                    <h4 class="modal-title sign_head">Edit Template</h4>
                    <p type="button" class="info" data-dismiss="modal"><img
                            class="float-right modal_close-icon modal_crossarrow" src="{{ asset('asset/images/cancel.png') }}"></p>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <form id="edit-template-form">
                        <p class="mb-2 py-0 sign_fontsize">Template Name<span class="text-danger px-1">* </span></p>
                        <input type="hidden" name="templateid" value="" id="templateid">
                        <input type="text" placeholder="Enter Template Name" class="px-3 py-2 signup_input w-100 rounded"
                            requried maxlength="100" minlength="5" name="templatename" id="templatename">
                        <span class="text-danger">
                            <strong id="templatename-error" class="new_error_class templatename-error"></strong>
                        </span>
                        <p class="mb-2 py-0 sign_fontsize">Subject<span class="text-danger px-1">* </span></p>
                        <input type="text" placeholder="Enter Subject" class="px-3 py-2 signup_input w-100 rounded"
                            requried maxlength="100" minlength="5" name="subject" id="subject">
                            <span class="text-danger">
                                <strong id="subject-error" class="new_error_class subject-error"></strong>
                            </span>
                        <p class="sign_fontsize pt-3 mb-2">Message</p>
                        <textarea class="form-control summernote" aria-label="With textarea" row="10" cols="50" name="message" id="message"></textarea>
                        <span class="text-danger">
                            <strong id="message-error" class="new_error_class message-error"></strong>
                        </span>
                    </form>
                </div>
                <!-- footer -->
                <div class="modal-footer">
                    <div class="col-6">
                        <button type="submit" class="signin_button  px-3 py-2 rounded" onclick="updatetemplate()">Update</button>
                    </div>
                    <div class="col-6 text-right">
                        <button type="button" class="btn btn btn-secondary py-2" data-dismiss="modal">cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <!-- modal -->
    <div class="modal fade" id="deletecollection">
        <div class="modal-dialog">
            <div class="modal-content mx-auto py-2">
                <!-- header -->
                <div class="modal-header justify-content-end pb-0">
                    <p type="button" class="info" data-dismiss="modal"><img
                            class="float-right modal_close-icon modal_crossarrow" src="{{ asset('asset/images/cancel.png') }}"></p>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <p class="sign_head">Do you want to Delete this Template ?</p>
                </div>
                <div class="modal-footer justify-content-end px-3">
                    <button type="button" class="signup_button px-4 py-2 rounded mr-2">Ok</button>
                    <button type="button" class="btn btn-secondary py-2" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <!-- modal -->
    <div class="modal fade" id="createtemplate" style="overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content mx-auto py-2">
                <!-- header -->
                <div class="modal-header pb-0">
                    <h4 class="modal-title sign_head">Create Template</h4>
                    <p type="button" class="info" data-dismiss="modal"><img
                            class="float-right modal_close-icon modal_crossarrow"src="{{ asset('asset/images/cancel.png') }}"></p>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <form id="edit-template-form">
                        <p class="mb-2 py-0 sign_fontsize">Template Name<span class="text-danger px-1">* </span></p>
                        <input type="hidden" name="templateid" value="" id="templateid">
                        <input type="text" placeholder="Enter Template Name" class="px-3 py-2 signup_input w-100 rounded"
                            requried maxlength="100" minlength="5" name="templatename" id="ctemplatename">
                        <span class="text-danger">
                            <strong id="ctemplatename-error" class="new_error_class templatename-error"></strong>
                        </span>
                        <p class="mb-2 py-0 sign_fontsize">Subject<span class="text-danger px-1">* </span></p>
                        <input type="text" placeholder="Enter Subject" class="px-3 py-2 signup_input w-100 rounded"
                            requried maxlength="100" minlength="5" name="subject" id="csubject">
                            <span class="text-danger">
                                <strong id="csubject-error" class="new_error_class subject-error"></strong>
                            </span>
                        <p class="sign_fontsize pt-3 mb-2">Message</p>
                        <textarea class="form-control summernote" aria-label="With textarea" row="10" cols="50" name="message" id="cmessage"></textarea>
                        <span class="text-danger">
                            <strong id="cmessage-error" class="new_error_class message-error"></strong>
                        </span>
                    </form>
                </div>
                <!-- footer -->
                <div class="modal-footer">
                    <div class="col-6">
                        <button type="button" id="preview"
                        class="signin_button px-4 py-2 emailsend rounded">Preview</button> 
                        <button type="submit" class="signin_button  px-3 py-2 rounded" onclick="submittemplate()">Create</button>
                    </div>
                    
                    <div class="col-6 text-right">
                        <button type="button" class="btn btn btn-secondary py-2" data-dismiss="modal">cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="modal newmodalclass fade" id="previewmodal" style="overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content mx-auto">
                <!-- header -->
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>

             
                    <div class="col-12 pt-3">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="modal-title sign_head">Preview Template</h4>
                            </div>
                            <div class="col-4">
                                <p type="button" class="info" data-dismiss="modal"><img
                                        class="float-right modal_close-icon"
                                        src="{{ asset('/') }}asset/images/close.png"></p>
                            </div>
                        </div>
                    </div>
                    <!-- body -->
                    <div class="modal-body">
                        <table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">

  
                            <tr>
                        
                                <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">
                        
                                  
                        
                                    <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                        
                                        <tr>
                        
                                            <td class="row" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                        
                                                <tr>
                                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:3px;text-align:left;padding-top: 42px;" >
                                                        <b>Template Name</b> :<span id="previewtemplate"></span>     
                                                    </td>
                                                </tr>
                                <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:3px;text-align:left;padding-top: 42px;" >
                                        <b>Subject</b> :<span id="previewsubject"></span>     
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;" >
                                       <b> Message</b> :<p id="previewmessage"></p>     </td>
                                </tr>
          </table>
                        
                                                <br></td>
                        
                                        </tr>
                        
                                    </table>      
                        
                                 </td>
                        
                            </tr>
                            <tr >
                                <td>
                                    <b>
                                        @for ($i=0; $i < 67; $i++)
                                            -
                                        @endfor
                                    </b>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;"
                                >
                                <b>Disclaimer: </b>
                                 The sender of this email is registered with www.zeronoticeperiod.com as {{ Auth::guard('company')->user()->name }} using www.zeronoticeperiod.com services. 
                                 The responsibility of checking the authenticity of offers/correspondence lies with you entirely. 
                                 If you consider the content of this email inappropriate or spam, you may forward this email to: 
                                 info@zeronoticeperiod.com. Please note this email is a private message from the recruiter. 
                                 You are advised not to forward this email to protect your account from unauthorized access.
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;"
                                >
                                <b>General Advise :</b>
                                Please do not pay any money to anyone who promises to find you a job. 
                                This could be in any form. The money could be asked for upfront or it could be asked after trust has been built after some communication has been exchanged. 
                                Please ensure you are not being scammed and in case you are suspicious please contact info@zeronoticeperiod.com for advise.
                                </td>
                            </tr>
                        
                        </table>
                      
                    </div>
                    <div class="modal-footer justify-content-end px-3">
                        <button type="button" class="btn btn-secondary py-2 mr-3" id="previewclose">Back</button>
                                          
                    </div>
               
            </div>
        </div>
    </div>

</div>
<div class="container">
    <div class="modal newmodalclass" id="viewmodal" style="overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content mx-auto">
                <!-- header -->
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>

             
                    <div class="col-12 pt-3">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="modal-title sign_head">View Template</h4>
                            </div>
                            <div class="col-4">
                                <p type="button" class="info" data-dismiss="modal"><img
                                        class="float-right modal_close-icon"
                                        src="{{ asset('/') }}asset/images/close.png"></p>
                            </div>
                        </div>
                    </div>
                    <!-- body -->
                    <div class="modal-body">
                        <table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">

  
                            <tr>
                        
                                <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">
                        
                                  
                        
                                    <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                        
                                        <tr>
                        
                                            <td class="row" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                        
                                                <tr>
                                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:3px;text-align:left;padding-top: 42px;" >
                                                        <b>Template Name</b> :<span id="viewtemplate"></span>     
                                                    </td>
                                                </tr>
                                <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:3px;text-align:left;padding-top: 42px;" >
                                        <b>Subject</b> :<span id="viewsubject"></span>     
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;" >
                                       <b> Message</b> :<p id="viewmessage"></p>     </td>
                                </tr>
          </table>
                        
                                                <br></td>
                        
                                        </tr>
                        
                                    </table>      
                        
                                 </td>
                        
                            </tr>

                            <tr >
                                <td>
                                    <b>
                                        @for ($i=0; $i < 67; $i++)
                                            -
                                        @endfor
                                    </b>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;"
                                >
                                <b>Disclaimer: </b>
                                 The sender of this email is registered with www.zeronoticeperiod.com as {{ Auth::guard('company')->user()->name }} using www.zeronoticeperiod.com services. 
                                 The responsibility of checking the authenticity of offers/correspondence lies with you entirely. 
                                 If you consider the content of this email inappropriate or spam, you may forward this email to: 
                                 info@zeronoticeperiod.com. Please note this email is a private message from the recruiter. 
                                 You are advised not to forward this email to protect your account from unauthorized access.
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;"
                                >
                                <b>General Advise :</b>
                                Please do not pay any money to anyone who promises to find you a job. 
                                This could be in any form. The money could be asked for upfront or it could be asked after trust has been built after some communication has been exchanged. 
                                Please ensure you are not being scammed and in case you are suspicious please contact info@zeronoticeperiod.com for advise.
                                </td>
                            </tr>
                        
                        </table>
                      
                    </div>
                    <div class="modal-footer justify-content-end px-3"  data-dismiss="modal">
                        <button type="button" class="btn btn-secondary py-2 mr-3">close</button>
                    </div>
               
            </div>
        </div>
    </div>

</div>


@include('includes.footer')

@endsection

@push('scripts')

@include('includes.immediate_available_btn')
<script>
    $(document).ready(function() {
       
      
        $('textarea.summernote').summernote({
           placeholder: 'Write Your Message',
            tabsize: 2,
            height: 300,
            toolbar: [  
                    ['font', ['bold', 'italic', 'underline', 'clear']], 
                    ['para', ['ul', 'ol', 'paragraph']],    
                ],  
                callbacks: {
                    onPaste: function(e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
                    }
               }
          
          
          });
    });
  </script>


<script>
    function edittemplate(id)
    {
       
        $.ajax({
                url: "{{ route('get.template-data') }}",
                method: 'post',
                data: {
                    _token:"{{ csrf_token() }}",
                    id:id,
                  
                },
                success: function(data){

                    $("#edittemplate").modal('show');
                    $("#templatename").val(data.result.templatename);
                    $("#subject").val(data.result.subject);
                    $('#message').summernote('code', data.result.message);
                    // $("#message").val(data.result.message);
                    $("#templateid").val(data.result.id);
                },
                error:function(result)
                {
                    alert('error');
                }
            });
    }
    function viewtemplate(id)
    {
       
        $.ajax({
                url: "{{ route('get.template-data') }}",
                method: 'post',
                data: {
                    _token:"{{ csrf_token() }}",
                    id:id,
                  
                },
                success: function(data){
                    var template = data.result.templatename;
                    var subject =  data.result.subject; 
                    var description = data.result.message;
                    $('#viewsubject').html(subject);
                    $('#viewmessage').html(description);
                    $('#viewtemplate').html(template);
                    $("#viewmodal").modal('show');
                },
                error:function(result)
                {
                    alert('error');
                }
            });
    }

    function updatetemplate()
    {

        $( '#templatename-error').html("");
        $( '#subject-error').html("");
        $( '#message-error').html("");
       
        $.ajax({
                url: "{{ route('update.template-data') }}",
                method: 'post',
                data: {
                    _token:"{{ csrf_token() }}",
                    id:$('#templateid').val(),
                    templatename: $('#templatename').val(),
                    subject: $('#subject').val(),
                    message: $('#message').val(),
                  
                },
                success: function(data){

                    if(data.success) {
                        $("#myElem").show();
                        setTimeout(function() { $("#myElem").hide(); }, 5000);
                        $("#edittemplate").modal('hide');
                        window.location.reload();
                        

                    }

               //  alert('success');
              
               if(data.errors)
                    {
                 if(data.errors.templatename){
                            $( '#templatename-error').html( data.errors.templatename[0] );
                        }

                        if(data.errors.subject){
                            $( '#subject-error').html( data.errors.subject[0] );
                        }

                        if(data.errors.message){
                            $( '#message-error').html( data.errors.message[0] );
                        }

               
                }
            },
                error:function(json)
                {

                }
            });
    }


    function deletetemplate(id) {
        if (confirm('Are you sure! you want to delete?')) {
         $.post("{{ route('delete.template') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                .done(function (response) {
            if (response == 'ok')
            {
                
                window.location.reload();
            } else
            {
                $("#myElem1").show();
                window.location.reload();
            }
            });
    }
    }


    function createtemplate()
    {

        $("#createtemplate").modal('show');

    }


    function submittemplate()
    {

        $( '#ctemplatename-error').html("");
        $( '#csubject-error').html("");
        $( '#cmessage-error').html("");
       
        $.ajax({
                url: "{{ route('store.template-data') }}",
                method: 'post',
                data: {
                    _token:"{{ csrf_token() }}",                  
                    templatename: $('#ctemplatename').val(),
                    subject: $('#csubject').val(),
                    message: $('#cmessage').val(),
                  
                },
                success: function(data){

                    if(data.success) {
                        $("#myElem2").show();
                        setTimeout(function() { $("#myElem2").hide(); }, 5000);
                        $("#createtemplate").modal('hide');
                        window.location.reload();

                    }

               //  alert('success');
              
               if(data.errors)
                    {
                 if(data.errors.templatename){
                            $( '#ctemplatename-error').html( data.errors.templatename[0] );
                        }

                        if(data.errors.subject){
                            $( '#csubject-error').html( data.errors.subject[0] );
                        }

                        if(data.errors.message){
                            $( '#cmessage-error').html( data.errors.message[0] );
                        }

               
                }
            },
                error:function(json)
                {

                }
            });

    }

    $("#preview").click(function(){
        var template =  $('#ctemplatename').val();
        var subject =  $('#csubject').val(); 
        var description = $('#cmessage').val();

        // alert(subject);

        $('#previewsubject').html(subject);
        $('#previewmessage').html(description);
        $('#previewtemplate').html(template);

        $("#createtemplate").modal('hide');

        $("#previewmodal").modal('show'); 
        
        });
        $("#previewclose").click(function(){


        $("#createtemplate").modal('show');

        $("#previewmodal").modal('hide');

    });
</script>

@endpush

