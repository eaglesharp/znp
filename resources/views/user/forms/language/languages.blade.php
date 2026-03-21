{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

<div id="lang_Known" class="col-lg-6 px-0  pb-3 pt-4 mt-0 mt-md-3 profile_head  rounded">

    <div class="myprofile_font">Languages Known<i

        class="fa fa-pencil pl-2" aria-hidden="true"></i></div></div>

        <div class="col-12 box_profile px-sm-5 py-4 py-sm-5 rounded">

    <div class="row">

        <div class="col-12 personal-languages">



        <div class="table-responsive">

        <?php 

         $data2=\App\ProfileLanguage::where('user_id',$user->id)->get();

        ?>

     	

{{--      

     @foreach (unserialize($data2->language_level) as $order)

     {{ $order }}

 @endforeach

      --}}

         

     

       

            <table class="table">

                <thead>

                    <th class="">Type</th>

                    <th class="">Languages</th>

                    <th class="">Read</th>

                    <th class="">Write</th>

                    <th class="">Speak</th>

                    <th class="">Action</th>

                </thead>

                @foreach($data2 as $data)

                <?php 

                $language=(isset($data->language_level) ? $data->language_level : '');

                $datas=(isset($language) ? unserialize($language) : '');

                

            

                ?>

              

                <tr>

                    <td class="pb-0">{{$data->language_type}}</td>

                    <td class="pb-0">{{$data->language}}</td>



                    <td class="pb-0">@if($datas){{in_array(1,$datas) ? '✔' :null}}@endif</td>

                  

                    <td class="pb-0">@if($datas){{in_array(2,$datas) ? '✔' :null}}@endif</td>

                 

                 

                    <td class="pb-0">@if($datas){{in_array(3,$datas) ? '✔' :null}}@endif</td>

                

                    <td class="pb-0 d-flex"><a href="javascript:void:"  data-toggle="modal" data-target="#languages_edit" onclick="showfrontLanguageEditModal({{$data->id}});" value="{{$data->id}}">Edit</a> <span

                            class="px-2">|</span> <a href="javascript:;" onclick="delete_profile_language({{$data->id}});" value="{{$data->id}}">Delete</a></td>

                </tr>

          

            {{-- {{$data->$language_level}} --}}

                @endforeach

            </table>

            

        </div>

    </div>

    <div class="col-12 pt-3 pt-sm-0">

        <a href="#" data-toggle="modal" data-target="#languages_add">Add Languages</a>
       
    </div>
    <div class="col-12">
       <p id="success_id1"  class="p-success1 px-0"></p>
    </div>
</div>

</div>

@include('user.forms.language.language_modal')







<div class="modal fade bs-modal-lg" id="add_language_modal1234" tabindex="-1" role="dialog" aria-hidden="true">

  

 

    @include('user.forms.language.language_edit_modal')

    

  

    

    </div>

@push('css')

<style type="text/css">

    .datepicker>div {

        display: block;

    }

</style>

@endpush

@push('scripts') 



<script type="text/javascript">  



    /**************************************************/



 
    $("#language_id option:first").attr("disabled", "disabled");  

  


    function submitProfileLanguageForm() {

    

     

    var form = $('#add_edit_front_profile_language');



    $.ajax({



    url     : form.attr('action'),



            type    : form.attr('method'),



            data    : form.serialize(),



            dataType: 'json',



            success : function (json){



                // $('#success_id').html('Sucessfully Updated');
                $('.' + 'p-success').html('<p class="alert alert-success">' + 'Languages Updated Successfully ' + '</p>');

                location.reload(true);



         



            },



            error: function(json){

                document.getElementById('saving').innerHTML = 'Save';

                if (json.status === 422) {

        var resJSON = json.responseJSON;

        $('.help-block').html('');

        $.each(resJSON.errors, function (key, value) {

        $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

        $('#div_' + key).addClass('has-error');

        });

        }





            }



    });



    }

    

    

    

    function updateProfileLanguageForm() {

    



    var form = $('#edit_front_profile_language');

//alert('hello');


    $.ajax({



    url     : form.attr('action'),



            type    : form.attr('method'),



            data    : form.serialize(),



            dataType: 'json',



            success : function (json){

                $('.' + 'p-success').html('<p class="alert alert-success">' + 'Languages Updated Successfully ' + '</p>');

             location.reload(true);



         



            },



            error: function(json){

                document.getElementById('saving1').innerHTML = 'Save';

                if (json.status === 422) {

        var resJSON = json.responseJSON;

        $('.help-block').html('');

        $.each(resJSON.errors, function (key, value) {

        $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

        $('#div_' + key).addClass('has-error');

        });

        }



            }



    });



    }



    function delete_profile_language(id) {



    var msg = "{{__('Are you sure! you want to delete?')}}";



    if (confirm(msg)) {



    $.post("{{ route('delete.front.profile.language') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})



            .done(function (response) {



            if (response == 'ok')



            {



           console.log(response);



            } else



            {

               // alert('hello');

                $('#success_id1').html('<p class="alert alert-success">' + 'Language Deleted Sucsessfully ' + '</p>');

                location.reload(true);



            }



            });



    }



    }



    // $(document).ready(function(){



    // showLanguages();



    // });



    // function showLanguages()



    // {



    // $.post("{{ route('show.front.profile.languages', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})



    //         .done(function (response) {



    //         $('#language_div').html(response);



    //         });



    // }

    

    function showfrontLanguageEditModal(profile_language_id){

        // $("#language_id1 option:first").attr("disabled", "disabled"); 

    $("#add_language_modal1234").modal();

    loadfrontLanguageEditForm(profile_language_id);

    }

    function loadfrontLanguageEditForm(profile_language_id){

    

    $.ajax({

    type: "POST",

            url: "{{ route('get.front.profile.language.edit.form', $user->id) }}",

            data: {"profile_language_id": profile_language_id, "_token": "{{ csrf_token() }}"},

            datatype: 'json',

            success: function (json) {

                // $('#add_language_modal1234').modal('show'); 

                $("#add_language_modal1234").html(json.html);

            }

    });

    }

    

    


        $(document).ready(function(){

             $('#success_id').hide();
             $('.btns_submit').click(function(){
                    $('#success_id').show();
                });
                
        });


    

    
        
    



</script> 



@endpush