@extends('layouts.app')

@section('content')

@include('includes.header')



<section class="postjob-listing py-5 section_canddashboard">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                    <h2 class="line_change_1">Job Applies</h2>
            </div>
          
          @foreach ($jobs as $job)
              @php
                     $applyjob = \App\JobApply::where('job_id', $job->id)->first();
              @endphp
         
            <div class="col-12 boxing rounded justify-content-center bg-white mt-4 pt-4">
                <div class="row">
                    <div class="col-lg-1 pr-0 mr-0 text-lg-center text-start pl-2 pl-lg-4 col-2">
                        @if($job->company->logo)
                        <img src="{{ asset('company_logos/'.$job->company->logo) }}" width="50" height="50"> 
                        @else
                        <img src="{{asset('/')}}asset/images/industry-logo.png" width="50" height="50">
                        @endif
                    </div>
                    <div class="col-lg-8 select_input_cus bg-white pl-lg-0 ml-0 col-10 pl-2">
                            <h2 class="line_change">{{ $job->job_title }}</h2>
                            <p class="m-0 text-muted font-weight-bold">{{ $job->company->name }}</p>
                            <?php
                                if (!function_exists('is_serialized')) {
                                    function is_serialized($data) {
                                        return @unserialize($data) !== false;
                                    }
                                }
                                ?>

                                @if(is_serialized($job->location))
                                    <?php $unserializedData = unserialize($job->location); ?>
                                    <p>{{ implode(',',$unserializedData) }}</p>
                                @else
                                    <p>{{ $job->location }}</p>
                                @endif
                      


                            {{-- <p class="text-muted font-weight-bold">{{ checkAndUnserialize($job->location) ??'' }}</p> --}}


                    </div>
                    <div class="px-lg-4 col-lg-3 text-center cv-search-btns my-auto d-lg-block d-none">
                        <a href="{{ url('job/'.$job->slug) }}"><button type="submit" class="btn btn-apply mb-2 mb-sm-2 mr-2">View Job</button></a>
                        <p class="text-muted ">Applied on : {{ \Carbon\Carbon::parse($applyjob->created_at)->format('d-m-Y')  }}</p>
                    </div>
                    @php
                         $job_description = $job->job_description;

                        if(strlen($job_description) > 300)

                        {

                        $job_description = substr($job_description, 0, 300) . '...';

                        }
                    @endphp     
                    {{-- <div class="col-12 px-lg-5">
                        <ul class="list-inline job_view">
                            <input type="checkbox" hidden class="read-more-state" id="read-more-4">
                            <p class="m-0 pt-2"><span>Job Description:</span>{!! $job_description??'' !!}</p>
                        </ul>
                    </div> --}}
                    <div class="px-lg-4 col-12 cv-search-btns my-auto d-block d-lg-none">
                        <a href="{{ url('job/'.$job->slug) }}"><button type="submit" class="btn btn-apply mb-2 mb-sm-2 mr-2">View Job</button></a>
                    </div>
                </div>
            </div>

            @endforeach

            <div class="col-lg-12">
                <div class="pagiWrap pb-2">
            
                    <nav aria-label="Page navigation example">
                
                        @if (isset($jobs) && count($jobs))
                
                        {{ $jobs->appends(request()->query())->links() }} @endif
                
                    </nav>
                
                </div>
            </div>
          
        </div>
    </div>
</section>




@include('includes.footer')

@endsection