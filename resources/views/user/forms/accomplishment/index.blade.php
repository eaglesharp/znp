<?php                     

   $accomplishments = \App\Accomplishment::where('user_id',$user->id)->get();

?>       


<div id="Accomplishment" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">

    <div class="myprofile_font">Accomplishment</div>  

</div>

<div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">

    <div class="row ">

        <div class="col-12">   
            <a href="#" title="Add Accomplishment" class="project_add" data-toggle="modal"

            data-target="#accomplishment_add">ADD</a>
            <div class="myprofile_font">Online Profile</div>  

            <p>Add link to online profiles (e.g. Linkedin, Github etc.).</p> 

            <div class="">

                    @foreach($accomplishments as $acc)

                    
                        <p class="my-0 sign_fontsize"><span>Social Profile Name: </span>{{$acc->profile_name}}  <a href="javascript:void(0)"><i

                            class="fa fa-pencil pl-2 pt-3" onclick="editfrontaccomplishment({{$acc->id}})" aria-hidden="true"></i></a><a href="javascript:void(0)" ><i

                                class="fa fa-trash pl-2 pt-3" aria-hidden="true" onclick="delete_front_accomplishment({{$acc->id}})"></i></a></p>

                        <p class="my-0 sign_fontsize"><span>URL : </span>{{$acc->profile_url}} </p>

                        <p class="my-0 sign_fontsize" style="word-break: break-all;"><span>Description : </span>{!! $acc->description !!}</p>

                        


                @endforeach

                <p id="success_id53"  class="p-success px-0"></p>

            </div>   
       
        </div>

    

        <div class="col-12">   

          
            <div class="d-flex justify-between-center">
                <p class="myprofile_font">Whitepaper/Presentation/Patents/Awards</p> 
            </div>  

         <form action="{{ url('store-white-paper') }}" method="POST" id="white_paper_form"  enctype="multipart/form-data" >
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id??'' }}">
        
            <div class="">

                <textarea type="text" class="w-100 signup_input rounded px-3 py-2 edit" id="white_paper"
                placeholder="Details" name="white_paper" maxlenght="1000"
                spellcheck="false">{{ old('white_paper', (isset($user->white_paper))? $user->white_paper:'') }}</textarea>


              


            @if($errors->has('white_paper'))

            <span class="error new_error_class">{{$errors->first('white_paper')}}</span>

            @endif

            <span class="help-block white_paper-error"></span> 
            


            </div>

            <div>
                <input type="file" name="file" class="w-100  rounded py-2" >
                            <p id=""  class="p-success success_id53 px-0"></p>


            </div>
            
            
            @if((isset($user->showcvs()->file) ? $user->showcvs()->file :''))



            <div class="form-group edit" style="border 1px solid"><br>

                <?php 

                    $file=(isset($user->showcvs()->file) ? $user->showcvs()->file :'');

                    ?>

                <button target="_blank"
                    class="btn edit">{{ImgUploader::print_doc("whitepaper/$file", $file, $file)}} </button>
                <a href="{{url('delete-whitepaper',$user->id)}}" class="btn btn-danger">Delete</a>



            </div>

            @endif
            
            <div class="col-lg-12  mt-2 text-center">

                <a onclick="submitwhitepaper()" class="signin_button rounded px-3 py-2 edit" >Submit</a>

            </div>
        </form>
       
        </div>


    </div>

  

</div>



<!-- Online Profile modal -->

@include('user.forms.accomplishment.accomplishment_modal')



<div class="modal" id="edit_accomplishment_modal" role="dialog">

    @include('user.forms.accomplishment.accomplishment_edit_modal')
</div>

<!-- WhitePaper modal -->

{{-- @include('user.forms.whitepaper.whitepaper_modal') --}}





@push('scripts') 



<script type="text/javascript">

function submitwhitepaper() {

        //alert('hello');

        var form = $('#white_paper_form');

        $.ajax({

            url     : form.attr('action'),

            type    : form.attr('method'),
            
            data: new FormData($('#white_paper_form')[0]),

            processData: false,

            contentType: false,

            dataType: 'json',

            success : function (json){        

                //alert('success');
                $(".success_id53").show(); 
                //$(".new_error_class").hide(); 

                $('.help-block').hide();
                $(".newtest").css("border-color","#ccc ");

                $(".success_id53").html("<div class='alert alert-success'>{{__('White Paper updated successfully')}}</div>");
                setTimeout(function() { $(".success_id53").hide(); }, 5000);       

            },

            error: function(json){


            
            // document.getElementById('savekey').innerHTML = 'Save';
            
        //location.reload(true);


            if (json.status === 422) {

            var resJSON = json.responseJSON;

            $('.help-block').show();

            $('.help-block').html('');

            $.each(resJSON.errors, function (key, value) {

            $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

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

function submitaccomplishmentform() {
   

        var form = $('#add_accomplishment');

        $.ajax({

        url     : form.attr('action'),

                type    : form.attr('method'),

                data    : form.serialize(),

                dataType: 'json',

                success : function (json){

               // alert('success');

               $('#acc_success').html('<p class="alert alert-success">' + 'Accomplishment Updated Successfully ' + '</p>');

               setTimeout(function() { $("#acc_success").hide(); }, 5000);

                location.reload(true);


                },

                error: function(json){

                

                //alert('error');

                if (json.status === 422) {

                var resJSON = json.responseJSON;

                $('.help-block').html('');

                $.each(resJSON.errors, function (key, value) {

                $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

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







    function editfrontaccomplishment(accomplishment_id){
  
    $("#edit_accomplishment_modal").modal();

    loadaccomplishmentEditForm(accomplishment_id);

    }



    function loadaccomplishmentEditForm(accomplishment_id){



    $.ajax({



    type: "POST",



            url: "{{ route('get.front.accomplishment.edit.form', $user->id) }}",



            data: {"accomplishment_id": accomplishment_id, "_token": "{{ csrf_token() }}"},



            datatype: 'json',



            success: function (json) {



            $("#edit_accomplishment_modal").html(json.html);



           

            }



    });



    }

    

    

    function updateaccomplishmentform() {

        var form = $('#edit_accomplishment');

        $.ajax({

        url     : form.attr('action'),

                type    : form.attr('method'),

                data    : form.serialize(),

                dataType: 'json',

                success : function (json){

               // alert('success');

               $('#success_id21').html('<p class="alert alert-success">' + 'Accomplishment Updated Successfully ' + '</p>');

               setTimeout(function() { $("#success_id21").hide(); }, 5000);

                location.reload(true);

                },

                error: function(json){

                

                //alert('error');

                if (json.status === 422) {

                var resJSON = json.responseJSON;

                $('.help-block').html('');

                $.each(resJSON.errors, function (key, value) {

                $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

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





    $("#year_of_passing_id option:first").attr("disabled","disabled");

    

    $("#month_of_passing_id option:first").attr("disabled","disabled");  

    

    $("#duration_id option:first").attr("disabled","disabled");

    

    

    function delete_front_accomplishment(id) {

        if (confirm('Are you sure! you want to delete?')) {

        $.post("{{ route('delete.front.accomplishment.detail') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})

                .done(function (response) {

                if (response == 'ok')

                {

              

                } else

                {

                    $('#success_id53').html('<p class="alert alert-success">' + 'accomplishment Deleted Successfully ' + '</p>');
                   location.reload(true);

                }

                });

        }

        }

    



</script>



@endpush