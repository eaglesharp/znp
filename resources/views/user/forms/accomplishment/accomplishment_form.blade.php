<form class="form" id="add_accomplishment" method="POST" action="{{ route('store.front.accomplishment', [$user->id]) }}">{{csrf_field()}}
    <div class="row">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Social Profile<span
                    class="text-danger px-1">*</span></label>
            <input type="text"  name="profile_name" class="w-100 signup_input rounded px-3 py-2" requried
                placeholder="Please Enter Your Social Profile Name"> 
                <span class="help-block profile_name-error"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">URL<span class="text-danger px-1">*</span></label>
            <input type="text" name="profile_url"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Please Enter Your Social Profile URL">
                
                <span class="help-block profile_url-error"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Description<span class="text-danger px-1">*</span></label>
            <textarea  name="description"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Description"></textarea>                
                <span class="help-block description-error"></span>
        </div>
    </div>
  
</form>