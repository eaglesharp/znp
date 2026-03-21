<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <div class="container">
        <!-- modal -->
        
        
                        <form class="px-3 px-sm-5" action="{{route('employer')}}" method="POST">
                        @csrf
                            <p class="sign_fontsize mb-2 pt-3">Company Name<span class="text-danger px-1">*</span></p>
                            <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Company Name"
                                maxlength="100" name="company_name" required>
                                
                                @error('company_name')  

                                <span class="text-danger" id="file-error">{{ $message }}</span>
                    
                                @enderror
                            <p class="sign_fontsize mb-2 pt-3">Offical Email<span class="text-danger px-1">*</span></p>
                            <input type="email" class="w-100 py-2 px-3 signin_input rounded" placeholder="Offical Email"
                                maxlength="100" name="email" required>
                                
                            <p class="sign_fontsize mb-2 pt-3">Mobile/Landline<span class="text-danger px-1">*</span></p>
                            <input type="tel" class="w-100 py-2 px-3 signin_input rounded" placeholder="Mobile/Landline"
                                maxlength="100" name="mobile" required>
                            <p class=" sign_fontsize mb-2 pt-3">Contact Person Name<span class="text-danger px-1">*</span>
                            </p>
                            <input type="text" class="w-100 py-2 px-3 signin_input rounded"
                                placeholder="Contact Person Name" maxlength="100" name="person_name" required>
                            <p class=" sign_fontsize mb-2 pt-3">GSTIN(optional)</p>
                            <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="GSTIN(optional)"
                                maxlength="100" name="gstin" required>
                            <div class="row px-0 pt-3 py-0">
                                <div class="col-6 form__radio-group m-0 py-0">
                                    <input type="radio" name="size" id="small" class="form__radio-input" value="company">
                                    <label class="form__label-radio" for="small" class="form__radio-label">
                                        <span class="form__radio-button">Company</span>
                                    </label>
                                </div>
                                
                                <div class="col-6 form__radio-group m-0 py-0">
                                    <input type="radio" name="size" id="large" class="form__radio-input" value="consultant" >
                                    <label class="form__label-radio" for="large" class="form__radio-label">
                                        <span class="form__radio-button">Consultant</span>
                                    </label>
                                </div>
                            </div>
                            <p class="sign_fontsize mb-2">Pin Code<span class="text-danger px-1">*</span></p>
                            <input type="text" class="w-100 py-2 px-3 signin_input rounded mb-2" placeholder="Pin code"
                                maxlength="100" name="pincode" required>
    
                            <div class="col-12 px-0 mb-2">
                                <input type="checkbox" class="checkbox_size align-middle" maxlength="100" name="promotional" requried>
                                <span class="sign_fontsize">I agree to receive Promotional Communication from ZNP</span>
                            
                            </div>
                            <div class="col-12 px-0 mb-3">
                                <input type="checkbox" class="checkbox_size  align-middle" maxlength="100" name="terms" required>
                                <span class="sign_fontsize">I read and agree
                                    <a href="#">Terms & Conditions</a>
                                </span>
                            </div>
                            <button type="submit" class="w-100 py-2 signin_button rounded">Send Request</button>
                        </form>
               
          
    </div>
    
@if(session()->has('message'))

<div class="alert alert-success">

    <ul>

        {{session()->get('message')}}

    </ul>

</div>

@endif
    
</body>
</html>