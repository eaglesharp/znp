<div class="container">

    <!-- modal -->

    <div class="modal" id="profile_sum">

        <div class="modal-dialog">

            <div class="modal-content  mx-auto">

                <!-- header -->

                <div class="modal-header pb-0">

                    <h4 class="modal-title sign_head">Add Current Company</h4>

                    <p type="button" class="info modal_crossarrow" data-dismiss="modal"><img

                            class="float-right modal_close-icon modal_crossarrow"

                            src="asset/images/close.png"></p>

                </div>

                <!-- body -->

     @include('user.forms.company.current_modal_form')

     <p id="success_id9"  class="p-success px-0"></p>

         <!-- footer -->

    <div class="modal-footer">

        <div class="col-12 text-right">

            <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

                data-dismiss="modal">Cancel</button>

            <button type="submit" class="signin_button  px-3 py-1 rounded"

                data-toggle="modal" data-target="#create" onClick="submitcurrentcompanyForm();">Save</button>

        </div>

    </div>

            </div>

        </div>

    </div>

    </div>

    

    <div class="modal fade bs-modal-lg" id="edit_current_company" tabindex="-1" role="dialog" aria-hidden="true">

  

 

        @include('user.forms.company.current_edit_modal')

        

      

        

        </div>

    

    

