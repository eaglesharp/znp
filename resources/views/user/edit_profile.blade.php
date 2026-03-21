@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 
<!-- Inner Page Title start --> 

<!-- Inner Page Title end -->


           
              
                       
                  
                                <!-- Personal Information -->
                                @include('user.inc.profile')                              
                                
						
						{{-- <div class="userccount">
                            <div class="formpanel mt0"
                                <!-- Personal Information -->
                                @include('user.inc.summary')                                
                            </div>
                        </div> --}}
						
						 {{-- <div class="userccount">
                            <div class="formpanel mt0">
                                <!-- Personal Information -->
                                @include('user.forms.cv.cvs')
                                @include('user.forms.project.projects')
                                @include('user.forms.experience.experience')
                                @include('user.forms.education.education')
                                @include('user.forms.skill.skills')
                                @include('user.forms.language.languages')
                            </div>
                        </div> --}}
						
						
						
						
						
						
						
						

@include('includes.footer')
@endsection
@push('styles')
<style type="text/css">
    .userccount p{ text-align:left !important;}
</style>
@endpush
@push('scripts')
@include('includes.immediate_available_btn')
@endpush