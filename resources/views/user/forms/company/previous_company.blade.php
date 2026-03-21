<div class="container">

    <!-- modal -->

    <div class="modal" id="previous_sum">

        <div class="modal-dialog">

            <div class="modal-content   mx-auto">

                <!-- header -->

                <div class="modal-header pb-0">

                    <h4 class="modal-title sign_head">Add Previous Company</h4>

                    <p type="button" class="info modal_crossarrow" data-dismiss="modal"><img

                            class="float-right modal_close-icon modal_crossarrow"

                            src="asset/images/close.png"></p>

                </div>

                <!-- body -->

   @include('user.forms.company.previous_modal_form')   <!-- footer -->

   <p id="success_id11"  class="p-success px-0"></p>

   <div class="modal-footer">

       <div class="col-12 text-right">

           <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

               data-dismiss="modal">Cancel</button>

           <button type="submit" class="signin_button  px-3 py-1 rounded"

               data-toggle="modal" data-target="#create" onclick="submitpreviouscompanyForm();">Save</button>

       </div>

   </div>

            </div>

        </div>

    </div>

    </div>

    <div class="modal fade bs-modal-lg" id="edit_previous_company" tabindex="-1" role="dialog" aria-hidden="true">

  

 

        @include('user.forms.company.previous_edit_modal')

        

      

        

        </div>

        @push('scripts')

        <script>

$(document).ready(function () {
$('#previous_start_date').datepicker({
    autoclose: true,
    format: 'mm-yyyy',
    todayHighlight: true,
    startDate: '12/1950',
    startView: "months", 
        minViewMode: "months"
});
var startDate = new Date('12/1950');
var FromEndDate = new Date();
var ToEndDate = new Date();
ToEndDate.setDate(ToEndDate.getDate() + 365);

$('#previous_start_date').datepicker({
    weekStart: 1,
    startDate: '09/2019',
    endDate: FromEndDate,
    autoclose: true
})
    .on('changeDate', function (selected) {
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#previous_end_date').datepicker('setStartDate', startDate);
    });
$('#previous_end_date')
    .datepicker({
        weekStart: 1,
        startDate: startDate,
        endDate: ToEndDate,
        format: 'mm-yyyy',
        autoclose: true,
        startView: "months", 
        minViewMode: "months"
    })
    .on('changeDate', function (selected) {
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('#previous_start_date').datepicker('setEndDate', FromEndDate);
    });

});



</script>
            
        @endpush