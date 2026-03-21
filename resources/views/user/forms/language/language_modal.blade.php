{{-- <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form class="form" id="add_edit_profile_language" method="POST" action="{{ route('store.front.profile.language', [$user->id]) }}">{{ csrf_field() }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{__('Add Language')}}</h4>
            </div>
            @include('user.forms.language.language_form')
            
            <div class="modal-footer">
                <button type="button" class="btn btn-large btn-primary" onClick="submitProfileLanguageForm();">{{__('Add Language')}} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
            </div>
        </form>
    </div>
    <!-- /.modal-content --> 
</div>
<!-- /.modal-dialog --> --}}

<div class="container">
    <!-- modal -->
    <div class="modal" id="languages_add">
        <div class="modal-dialog">
            <div class="modal-content mx-auto">
                <!-- header -->
                <div class="modal-header pb-0">
                    <h4 class="modal-title sign_head">Add Language</h4>
                    <p type="button" class="info " data-dismiss="modal"><img
                            class="float-right modal_close-icon modal_crossarrow"
                            src="asset/images/close.png"></p>
                </div>
                
           @include('user.forms.language.language_form')
            </div>
        </div>
    </div>
</div>