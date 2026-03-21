<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.default.css">

<style>
.bootstrap-tagsinput input {
 border: 0 !important;
}
</style>
<div class="container">
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
                <form class="form" id="add_front_keyskill" method="POST" action="{{ route('store.front.key.skill', [$user->id]) }}">{{ csrf_field() }}
                    <div class="modal-body">
                      
                          <div class='exampleSearch'>
                            <select name="keyskills[]" placeholder="Choose some technologies..." id="search" multiple="multiple">
                             {{-- <option selected value="1" id="1">Front</option> --}}
                           
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
                            <button type="submit" class="signin_button  px-3 py-1 rounded"
                                data-toggle="modal" data-target="#create" onclick="test();">Save</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>


@push('scripts') 
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script>
// $('#search').selectize();
// $body.on('click', '.my_button', function(e){
//   e.preventDefault();
//   var element = jQuery('#search');
  
//   if(element[0].selectize){
//     element[0].selectize.destroy();
//   }
  
//   element.selectize({
//     labelField: 'title',
//       valueField: 'id',
//       hideSelected:true,
//       persist:false,
//       create: false,
//       placeholder: "Dynamically options",
//     render: {
//         item: function(item, escape) { 
//           return "<div><span>" + escape(item.title) + "</span></div>";
//       },
//       option: function(item, escape) {
//           return "<div><span>" + escape(item.title) + "</span></div>";
//       }
//      },
//   });
  
//   jQuery.ajax({
//     type:"POST",
//     url: "{{ route('autocomplete.fetch') }}",
//     data:{query:query, _token:_token},
//     success:function(result){
//       var selectize = element[0].selectize;
//       var my_data = result;
//       if(my_data.length){
//         for(var i=0;i < my_data.length;i++){
//           var item = my_data[i]; 
//           var data = {
//             'id':item.id,
//             'title':item.job_skill,
            
//           };
//           selectize.addOption(data);
//           selectize.refreshOptions();
//         }
//       }
//     },
//     error:function(error){ 
//       console.log(error);
//     }
//   });
// });
var _token = $('input[name="_token"]').val();
var $select = $('#search').selectize({
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
// selectize.setValue(defaultValueIds);
    

function submitfrontkeyskills() {
   
   var form = $('#add_front_keyskill');
   $.ajax({
   url     : form.attr('action'),
           type    : form.attr('method'),
           data    : form.serialize(),
           dataType: 'json',
           success : function (json){
        
        
               location.reload(true);
          
           },
           error: function(json){
          alert('error');
           if (json.status === 422) {
           var resJSON = json.responseJSON;
           $('.help-block').html('');
           $.each(resJSON.errors, function (key, value) {
           $('.' + key + '-error').html('<strong class="text-danger">' + value + '</strong>');
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

    </script>
    
    
    
    
    



@endpush