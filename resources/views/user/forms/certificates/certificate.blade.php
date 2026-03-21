<div id="Technical_Certifications" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">

    <div class="myprofile_font">Other Certifications</div>

  

</div>

<div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">

    <div class="row ">

        <div class="col-12">

   

            <div class="">

    <?php 

        

    $certificates = \App\Certificate::where('user_id',$user->id)->get();

  

    ?>       

    

    @foreach($certificates as $cer)

                <h6 class="sign_head">{{$cer->certificate_name}}<a href="javascript:void(0)"><i

                            class="fa fa-pencil pl-2 pt-3" onclick="editfrontcertificate({{$cer->id}})" aria-hidden="true"></i></a><a href="javascript:void(0)" ><i

                                class="fa fa-trash pl-2 pt-3" aria-hidden="true" onclick="delete_front_certificate({{$cer->id}})"></i></a></h6>

                <p class="my-0 sign_fontsize"><span>Certification Agency / School : </span>{{$cer->certificate_agency}}</p>

                <p class="my-0 sign_fontsize"><span>Year of Certification : </span>{{$cer->year_of_passing}} - <span

                        class="sign_fontsize">{{$cer->month_of_passing}}</span></p>

                <p class="my-0 sign_fontsize"><span>Duration : </span>{{$cer->duration}}</p>

           @endforeach

            </div>
            <p id="success_id53"  class="p-success px-0"></p>
        </div>

    </div>

    <a href="#" title="Add Certifications" class="project_add" data-toggle="modal"

        data-target="#certificate_add">ADD</a>

</div>



<!-- certification modal -->

@include('user.forms.certificates.certificate_modal')



<div class="modal" id="edit_certificate_modal" role="dialog">

    @include('user.forms.certificates.certificate_edit_modal')



</div>





@push('scripts') 



<script type="text/javascript">



function submitcertificateform() {

        var form = $('#add_certificate');

        $.ajax({

        url     : form.attr('action'),

                type    : form.attr('method'),

                data    : form.serialize(),

                dataType: 'json',

                success : function (json){

               // alert('success');

               $('#success_id18').html('<p class="alert alert-success">' + 'Certificate Updated Successfully ' + '</p>');

               setTimeout(function() { $("#success_id18").hide(); }, 5000);

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







        function editfrontcertificate(certificate_id){

    

    //alert('hello');



    $("#edit_certificate_modal").modal();



    loadProfileProjectEditForm(certificate_id);



    }



    function loadProfileProjectEditForm(certificate_id){



    $.ajax({



    type: "POST",



            url: "{{ route('get.front.certificate.edit.form', $user->id) }}",



            data: {"certificate_id": certificate_id, "_token": "{{ csrf_token() }}"},



            datatype: 'json',



            success: function (json) {



            $("#edit_certificate_modal").html(json.html);



           

            }



    });



    }

    

    

    function updatecertificateform() {

        var form = $('#edit_certificate');

        $.ajax({

        url     : form.attr('action'),

                type    : form.attr('method'),

                data    : form.serialize(),

                dataType: 'json',

                success : function (json){

               // alert('success');

               $('#success_id21').html('<p class="alert alert-success">' + 'Certificate Updated Successfully ' + '</p>');

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

    

    

    function delete_front_certificate(id) {

        if (confirm('Are you sure! you want to delete?')) {

        $.post("{{ route('delete.front.certificate.detail') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})

                .done(function (response) {

                if (response == 'ok')

                {

              

                } else

                {

                    $('#success_id53').html('<p class="alert alert-success">' + 'Certificate Deleted Successfully ' + '</p>');
                   location.reload(true);

                }

                });

        }

        }

    



</script>



@endpush