<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

<link rel="stylesheet" href="/resources/demos/style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.default.css">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>

.bootstrap-tagsinput input {

 border: 0 !important;

}
.exampleSearch .select2-container {
    width: 100%!important; 
    
}
.exampleSearch .select2-selection {
    height: 100%!important; 
    display:flex!important;
    
}
.exampleSearch .select2-selection--multiple {
    background-position: 97% 50%;
    padding-right: 40px;
}


</style>



        <div class="modal-dialog">

            <div class="modal-content  mx-auto">

                <!-- header -->

                <div class="modal-header pb-0">

                    <h4 class="modal-title sign_head">Key Skills</h4>

                    <p type="button" class="info " data-dismiss="modal"><img

                            class="float-right modal_close-icon modal_crossarrow"

                            src="asset/images/close.png"></p>

                </div>

                <!-- body -->
               

                <form class="form" id="edit_front_keyskill" method="POST" action="{{ route('update.front.key.skill', [$user->id]) }}">{{ csrf_field() }}


                      {{ csrf_field() }}
                    <div class="modal-body">

                
                        <p id="success_id3"  class="p-success3 px-0"></p>

                        

               

                          <div class='exampleSearch'>

                           
                            <label class="mb-2 pt-3 sign_fontsize">Mention your key skills<span
                                class="text-danger px-1">*</span></label>
                     
                            <?php

                                $keyskills = \App\KeySkill::where('user_id', $user->id)->pluck('keyskill')->toArray();

                                $job_skills = \App\JobSkill::pluck('job_skill', 'id')->toArray();

                             ?>
                             
                             <select class="form-control js-example-tokenizer" name="keyskills[]" multiple="multiple">
                                @foreach($job_skills as $id => $job_skill)
                                    <option value="{{ $id }}" @if(in_array($id, $keyskills)) selected @endif>{{ $job_skill }}</option>
                                @endforeach
                            </select>

                            <span class="help-block keyskills-error"></span>

                          </div>

                        
                           

                                 

                            

                    </div>
                
                    <!-- footer -->

                    <div class="modal-footer">

                        <div class="col-12 text-right">

                            <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

                                data-dismiss="modal">Cancel</button>

                            <button type="button" class="signin_button  px-3 py-1 rounded"

                                data-toggle="modal" data-target="#create" id="savekey" onclick="submitfrontkeyskills();">Save</button>

                        </div>

                    </div>

            </div>

            </form>

        </div>


    


@push('scripts') 



<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


<script>



var _token = $('input[name="_token"]').val();

var $select = $('#search1').selectize({

        valueField: 'id',

        labelField: 'job_skill',

        searchField: 'job_skill',

        load: function (query, callback) {

            $.ajax({

                url: "{{ route('autocomplete.fetch') }}",

                type: "post",

 

                data:{query:query, _token:_token},

                success: function (response) { console.log(response.job_skill); $select.options = response; callback(response); }

            });

        }

    }); 

    var yourDefaultIds = [1,2];

// $select.setValue(defaultValueIds);



//     var selectize = $select[0].selectize;

//     var yourDefaultIds = [1,2];

// selectize.setValue(defaultValueIds);

    

function updatefrontkeyskills() {

   var keyskills = $('#search1').val(); 

   var form = $('#edit_front_keyskill');

   $.ajax({

   url     : form.attr('action'),

           type    : form.attr('method'),

           data    : {_token:_token,keyskills:keyskills},

           dataType: 'json',

           success : function (json){        

      //  alert('success');

            //    location.reload(true);

          

           },

           error: function(json){

        // location.reload(true);

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

   function submitfrontkeyskills() {

   
document.getElementById('savekey').innerHTML = 'Saving..';
var form = $('#edit_front_keyskill');

$.ajax({

url     : form.attr('action'),

       type    : form.attr('method'),

       data    : form.serialize(),

       dataType: 'json',

       success : function (json){        

        $('#success_id3').html('<p class="alert alert-success">' + 'Keyskill Updated Successfully' + '</p>');

           location.reload(true);

      

       },

       error: function(json){

       //  alert('error');

    //     $("#keyskils_thanks").modal();

    //     document.getElementById('savekey').innerHTML = 'Save';
        
    //  location.reload(true);


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
$(".js-example-tokenizer").select2({
    tags: true,
    placeholder: "Please enter key skills or technologies",
    tokenSeparators: [',']
})
    </script>

    

    

    

    

    







@endpush