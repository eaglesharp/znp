<div class="container">
    <!-- modal -->
    <div class="modal" id="NightInterviewAvailable">
        <div class="modal-dialog">
            <div class="modal-content  mx-auto py-2 px-3">
                <!-- header -->
                <div class="modal-header pb-0">
                    <h4 class="modal-title sign_head">Add Night Interview Availability</h4>
                    <p type="button" class="info" data-dismiss="modal"><img
                            class="float-right modal_close-icon modal_crossarrow"
                            src="asset/images/cancel.png"></p>
                </div>
                <!-- body -->
                @include('user.forms.interview.night_interview_form')
            </div>
        </div>
    </div>
</div>