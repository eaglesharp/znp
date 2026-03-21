

        <div class="modal-dialog">

            <div class="modal-content  mx-auto">

                <!-- header -->

                <div class="modal-header pb-0">

                    <h4 class="modal-title sign_head">Edit Project</h4>

                    <p type="button" class="info" data-dismiss="modal"><img

                            class="float-right modal_close-icon modal_crossarrow"

                            src="asset/images/close.png"></p>

                </div>

                <!-- body -->

             @include('user.forms.project.project_edit_form')

             <p id="success_id16"  class="p-success px-0"></p>

             <div class="modal-footer">

                <div class="col-12 text-right">

                    <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

                        data-dismiss="modal">Cancel</button>

                    <button type="submit" class="signin_button  px-3 py-1 rounded"

                        data-toggle="modal" data-target="#create" onClick="updateFrontProfileProjectForm();">Save</button>

                </div>

            </div>

             

            </div>

        </div>

