<form class="form" id="edit_accomplishment" method="POST" action="{{ route('update.front.accomplishment', [$user->id]) }}">{{csrf_field()}}
    <div class="row">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Social Profile<span
                    class="text-danger px-1">*</span></label>
            <input type="text"  name="profile_name" class="w-100 signup_input rounded px-3 py-2" value="{{(isset($accomplishment) ? $accomplishment->profile_name :'')}}" requried
                placeholder="Please Enter Your Social Profile Name"> 
                <input type="hidden" name="accomplishment_id" value="{{(isset($accomplishment) ? $accomplishment->id :'')}}">
                <span class="help-block profile_name-error"></span>
        </div>
    </div>
    <div class="row">   
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">URL<span class="text-danger px-1">*</span></label>
            <input type="text" name="profile_url"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Please Enter Your Social Profile URL" value="{{(isset($accomplishment) ? $accomplishment->profile_url:'')}}">                
                <span class="help-block profile_url-error"></span>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Description<span class="text-danger px-1">*</span></label>
            <textarea  name="description"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Description">{!! (isset($accomplishment) ? $accomplishment->description:'') !!}</textarea>                
                <span class="help-block description-error"></span>
        </div>
    </div>
   
</form>