

        <div class="modal-dialog">

            <div class="modal-content   mx-auto ">

                <!-- header -->

                <div class="modal-header pb-0">

                    <h4 class="modal-title sign_head">Edit Current Company</h4>

                    <p type="button" class="info modal_crossarrow" data-dismiss="modal"><img

                            class="float-right modal_close-icon modal_crossarrow"

                            src="asset/images/close.png"></p>

                </div>

                <!-- body -->

     @include('user.forms.company.current_edit_form')

     <p id="success_id8"  class="p-success px-0"></p>

         <!-- footer -->

    <div class="modal-footer">

        <div class="col-12 text-right">

            <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

                data-dismiss="modal">Cancel</button>

            <button type="submit" class="signin_button  px-3 py-1 rounded"

                data-toggle="modal" data-target="#create" onClick="updatecurrentcompany();">Save</button>

        </div>

    </div>

            </div>

        </div>

