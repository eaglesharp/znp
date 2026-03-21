@extends('layouts.app')



@section('content')
    <!-- Header start -->



    @include('includes.header')



    <!-- Header end -->



    <!-- Inner Page Title start -->

    @include('flash::message')



    <section class="section_signup">
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="container">

            <div class="col-md-12 col-lg-8 m-auto py-5">

                <div class="box py-4 rounded">

                    <h5 class="sign_head text-center pt-3 mb-3">Sign Up As An<span class=" sign_color"> Employer</span></h5>





                    <form class="px-3 px-sm-5 priceform row" action="{{ route('company.register.page.store') }}" method="POST"
                        enctype="multipart/form-data" id="priceform1">

                        {{ csrf_field() }}


                        {{-- @if ($errors->any())
    
                            @foreach ($errors->all() as $error)
    
                                <div>{{$error}}
                    </div>

                    @endforeach

                    @endif --}}

                        <div class="col-lg-6" id="div_company_name">



                            <input type="hidden" value="" id="plandetail" name="package_name">

                            <p class="sign_fontsize mb-2 pt-3">Company Name<span class="text-danger px-1">*</span></p>

                            <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Company Name"
                                maxlength="100" name="company_name" id="company_name" value="{{ old('company_name') }}">

                            @if ($errors->has('company_name'))
                                <span class="text-danger">{{ $errors->first('company_name') }}</span>
                            @endif

                        </div>


                        <div class="col-lg-6">
                            <p class="sign_fontsize mb-2 pt-3">Offical Email<span class="text-danger px-1">*</span></p>

                            <input type="email" class="w-100 py-2 px-3 signin_input rounded" placeholder="Offical Email"
                                maxlength="100" name="email" value="{{ old('email') }}">



                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif

                        </div>
                        <div class="col-lg-6">
                            <p class="sign_fontsize mb-2 pt-3">Password<span class="text-danger px-1">*</span></p>

                            <input type="password" class="w-100 py-2 px-3 signin_input rounded" placeholder="password"
                                maxlength="100" name="password" value="{{ old('password') }}">



                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="col-lg-6">
                            <p class="sign_fontsize mb-2 pt-3">Confirm password<span class="text-danger px-1">*</span></p>

                            <input type="password" class="w-100 py-2 px-3 signin_input rounded"
                                placeholder="Confirm Password" maxlength="100" name="confirm_password"
                                value="{{ old('confirm_password') }}">



                            @if ($errors->has('confirm_password'))
                                <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                            @endif
                        </div>

                        <div class="col-lg-6">
                            <p class="sign_fontsize mb-2 pt-3">Mobile/Landline<span class="text-danger px-1">*</span></p>

                            <input type="tel" class="w-100 py-2 px-3 signin_input rounded pricing-mobile"
                                placeholder="Mobile/Landline" maxlength="14" name="mobile" min="0"
                                value="{{ old('mobile') }}">


                            @if ($errors->has('mobile'))
                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>

                        <div class="col-lg-6">
                            <p class=" sign_fontsize mb-2 pt-3">Contact Person Name<span class="text-danger px-1">*</span>

                            </p>

                            <input type="text" class="w-100 py-2 px-3 signin_input rounded"
                                placeholder="Contact Person Name" maxlength="100" name="person_name"
                                value="{{ old('person_name') }}">


                            @if ($errors->has('person_name'))
                                <span class="text-danger">{{ $errors->first('person_name') }}</span>
                            @endif
                        </div>

                        <div class="col-lg-6">
                            <p class=" sign_fontsize mb-2 pt-3">Designation<span class="text-danger px-1">*</span>

                            </p>

                            <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Designation"
                                maxlength="100" name="designation" value="" value="{{ old('designation') }}">

                            @if ($errors->has('designation'))
                                <span class="text-danger">{{ $errors->first('designation') }}</span>
                            @endif
                        </div>

                        <div class="col-lg-6">
                            <p class=" sign_fontsize mb-2 pt-3">GSTIN (Optional)</p>

                            <input type="text" class="w-100 py-2 px-3 signin_input rounded"
                                placeholder="GSTIN (Optional)" onkeyup="toUpper(event)" maxlength="100" name="gstin">
                            <span class="help-block gstin-error"></span>
                        </div>
                        <div class="col-lg-6">
                            <p class=" sign_fontsize mb-2 pt-3">Company Logo

                            </p>
                            <input type="file" name="logo" class="form-control-file w-100"
                                id="exampleFormControlFile1" value="{{ old('logo') }}" accept=".jpg,.jpeg,.png">

                            <p
                                style="width: 287px;
                           font-size: 14px;
                           color: grey;margin-top: 5px;    margin-bottom: 0px;
                       ">
                                (Upload logo will accept only jpg,jpeg, Size should be lesser than 2 MB.)</p>

                            @if ($errors->has('logo'))
                                <span class="text-danger">{{ $errors->first('logo') }}</span>
                            @endif
                        </div>

                        <div class="col-lg-6">
                            <p class="sign_fontsize mb-2 pt-3">Type of Business Entity<span
                                    class="text-danger px-1">*</span></p>
                            <select name="company_type" id="select_company_type"
                                class="w-100 py-2 px-3 signin_input rounded">

                                <option selected disabled>Select Type of Business Entity</option>

                                <option value="freelancer">Freelancer/Individual</option>
                                <option value="sole">Sole proprietorship</option>
                                <option value="partnership">Partnership firm</option>
                                <option value="limited">Limited liability partnership</option>
                                <option value="private">Private or public limited company</option>


                            </select>


                            @if ($errors->has('company_type'))
                                <span class="text-danger">{{ $errors->first('company_type') }}</span>
                            @endif

                        </div>
                        <div class="col-12">
                            <div class="row px-0 pt-3 py-0">

                                <div class="col-6 form__radio-group m-0 py-0">

                                    <input type="radio" name="size" id="small" class="form__radio-input"
                                        value="company">

                                    <label class="form__label-radio" for="small" class="form__radio-label">

                                        <span class="form__radio-button">Company</span>

                                    </label>

                                </div>

                                <div class="col-6 form__radio-group m-0 py-0">

                                    <input type="radio" name="size" id="large" class="form__radio-input"
                                        value="Recruitment Firm">

                                    <label class="form__label-radio" for="large" class="form__radio-label">

                                        <span class="form__radio-button">Recruitment Firm</span>

                                    </label>

                                </div>

                                <div class="col-12">
                                    @if ($errors->has('size'))
                                        <span class="text-danger">{{ $errors->first('size') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="sign_fontsize mb-1">Pin Code<span class="text-danger px-1">*</span></p>

                            <input type="tel" class="w-100 py-2 px-3 signin_input rounded mb-2"
                                placeholder="Pin code" maxlength="100" name="pincode" value="{{ old('pincode') }}">


                            @if ($errors->has('pincode'))
                                <span class="text-danger">{{ $errors->first('pincode') }}</span>
                            @endif
                        </div>
                        <div class="col-6">
                            <p class="sign_fontsize mb-1">LinkedIn Profile<span class="text-danger px-1">*</span></p>

                            <input type="url" class="w-100 py-2 px-3 signin_input rounded mb-2"
                                placeholder="LinkedIn Profile" maxlength="100" name="linkedin"
                                value="{{ old('linkedin') }}">
                            @if ($errors->has('linkedin'))
                                <span class="text-danger">{{ $errors->first('linkedin') }}</span>
                            @endif
                        </div>

                        <div class="col-12 mb-2 mt-1">

                            <input type="checkbox" id="checkbox_sizes" class="checkbox_size align-middle"
                                name="promotional" maxlength="100" requried>

                            <label for="checkbox_sizes" class="sign_fontsize">I agree to receive Promotional

                                Communication from ZeroNoticePeriod</label>

                            </input>

                        </div>

                        <div class="col-12  mb-3">

                            <div class="dummy">

                                <input type="checkbox" id="Conditions" class="checkbox_size  align-middle"
                                    maxlength="100" name="terms">

                                <label for="Conditions" class="sign_fontsize">I have read, understood and agreed to the

                                    <a href="{{ url('employer-terms-and-conditions') }}" required>Terms & Conditions</a>
                                    and <a href="{{ url('privacy-policy') }}">Privacy Policy</a>

                                </label>

                            </div>


                            @if ($errors->has('terms'))
                                <span class="text-danger">{{ $errors->first('terms') }}</span>
                            @endif

                        </div>


                        <div class="col-12">
                            <button type="submit" class="w-100 py-2 signup_button rounded">Create your account</button>
                        </div>
                    </form>
                    <div class="col-12">

                        <div class="text-center pt-4 sign_fontsize ">Already have an account ? <a
                                href="{{ url('employer-login') }}">Sign
                                in</a></div>

                    </div>

                    <div class="col-12">

                        <div class="text-center pt-4 sign_fontsize">Sign up as an Jobseeker <a
                                href="{{ route('register') }}">Sign
                                up</a></div>

                    </div>

                </div>

            </div>
        </div>

    </section>




    @include('includes.footer')
@endsection
@push('scripts')
    <script>
        $('body').on('keyup', '.js-input-mobile', function() {
            var $input = $(this),
                value = $input.val(),
                length = value.length,
                inputCharacter = parseInt(value.slice(-1));

            if (!((length > 0 && inputCharacter >= 0 && inputCharacter <= 10) || (length === 1 && inputCharacter >=
                    7 &&
                    inputCharacter <= 10))) {
                $input.val(value.substring(0, length - 1));
            }
        });
    </script>
@endpush
