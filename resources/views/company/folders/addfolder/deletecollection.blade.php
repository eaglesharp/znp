<div class="modal-content mx-auto py-2">
    <!-- header -->
    <div class="modal-header justify-content-end pb-0">
        <p type="button" class="info" data-dismiss="modal"><img
                class="float-right modal_close-icon modal_crossarrow" src="asset/images/cancel.png"></p>
    </div>
    <!-- body -->
    <div class="modal-body">
        <p class="sign_head">Do you want to Delete this Collection ?</p>
    </div>
    <div class="modal-footer justify-content-end px-3">
        <a type="button" class="signup_button px-4 py-2 rounded mr-2 deletecollection" href="{{url('delete-collection',$collection->id)}}">Ok</a>
        <button type="button" class="btn btn-secondary py-2" data-dismiss="modal">Cancel</button>
    </div>
</div>