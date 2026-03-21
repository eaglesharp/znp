<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

<link rel="stylesheet" href="/resources/demos/style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.default.css">



<style>

.bootstrap-tagsinput input {

 border: 0 !important;

}

</style>

<div class="">

    <!-- modal -->

    <div class="modal" id="keyskils_add">

        <div class="modal-dialog">

            <div class="modal-content  mx-auto py-2">

                <!-- header -->

                <div class="modal-header pb-0">

                    <h4 class="modal-title sign_head">Add Skills</h4>

                    <p type="button" class="info " data-dismiss="modal"><img

                            class="float-right modal_close-icon modal_crossarrow"

                            src="asset/images/cancel.png"></p>

                </div>

                <!-- body -->

                <form class="form" id="add_front_keyskill1" method="POST" action="{{ route('store.front.key.skill', [$user->id]) }}">{{ csrf_field() }}

                    <div class="modal-body">

                      

                          <div class='exampleSearch'>

                            <select name="keyskills[]" placeholder="Choose some technologies..." id="search2" multiple="multiple">

                           
                                <span class="help-block keyskills-error"></span>
                          

                           

                            </select>

                          </div>

                        {{-- <input type="text" id="inputTag" name="inputTag" class="form_action" value=""

                            placeholder="Choose by skils*" data-role="tagsinput" required> --}}

                            

{{--                            

                                <input type="text border-0"  id="search-box"   placeholder="Choose by skills*" data-role="tagsinput" required />

                                <div id="suggesstion-box"></div> --}}

                            

                            

                           

                                   {{ csrf_field() }}

                            

                    </div>

                    <!-- footer -->

                    <div class="modal-footer">

                        <div class="col-12 text-right">

                            <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

                                data-dismiss="modal">Cancel</button>

                            <button type="button" class="signin_button  px-3 py-1 rounded"

                                data-toggle="modal" data-target="#create" onclick="submitfrontkeyskills();">Save</button>

                        </div>

                    </div>

            </div>

            </form>

        </div>

    </div>

   




@push('scripts') 

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>

<script>



var _token = $('input[name="_token"]').val();

var $select = $('#search2').selectize({

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



//     var selectize = $select[0].selectize;

//     var yourDefaultIds = [1,2];

// $select.setValue(defaultValueIds);

    





   

   

   



    </script>

    

    

    

    

    







@endpush