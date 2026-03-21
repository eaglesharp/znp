<div class="modal-body">

    <div class="form-body">

        <div class="form-group" id="div_profile_name">

            <label for="name" class="bold">Social Profile <span class="text-danger px-1">*</span></label>

            <input class="form-control" id="title" placeholder="Please Enter Your Certification Name" name="profile_name" type="text" value="{{(isset($accomplishment) ? $accomplishment->profile_name :'')}}">

            <span class="help-block profile_name-error"></span> 
        </div>
        <div class="form-group" id="div_profile_url">

            <label for="name" class="bold">URL <span class="text-danger px-1">*</span></label>

            <input class="form-control" id="title" placeholder="Please Enter Your Certification Name" name="profile_url" type="text" value="{{(isset($accomplishment) ? $accomplishment->profile_url :'')}}">

            <span class="help-block profile_url-error"></span> 
        </div>

        <div class="form-group" id="div_description">

            <label for="name" class="bold">Description <span class="text-danger px-1">*</span></label>

            <input class="form-control" id="title" placeholder="Please Enter Your Certification Name" name="description" type="text" value="{{(isset($accomplishment) ? $accomplishment->description :'')}}">

            <span class="help-block description-error"></span> 
        </div>


            



              

    </div>