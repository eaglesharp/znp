@extends('layouts.app')



@section('content')



<!-- Header start -->



@include('includes.header')
<style>
#overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 2;
    cursor: pointer;
}

#text {
    position: absolute;
    top: 50%;
    left: 50%;
    font-size: 50px;
    color: white;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
}
</style>
<section class="contact_bg-color">

    <div class="container contact_bg-color">

        <div class="row">

            <div class="col-lg-12 text-center py-5">

                <div class="contact_head-color py-1">

                Saved Search Results

                </div>

            </div>

        </div>

    </div>

</section>

<section class="section_draft py-4 py-sm-5">
    <div class="container">
            <div class="col-12 candidates_job-dashboard py-0 px-0 pt-0">

                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif

            </div>

            @php

            $searches = \App\SaveSearch::where('company_id',Auth::guard('company')->user()->id)->latest()->get();

            @endphp

            <div class="row pt-sm-3">
                @foreach($searches as $search)
                <div class="col-sm-6 col-lg-4 pb-4 mb-2">
                    <div class="boxing rounded px-4 h-100" id="checkbox_list">


                        <ul class="list-inline mb-1">

                            <li class="list-inline-item mb-3">
                                <h2 class="mb-0 myprofile_font d-inline-flex align-items-center">{{ $search->search_value??'' }}</h2>
                            </li>
                        </ul>
                        <ul class="list-inline saved-search mb-4">
                            @if($search->search)
                            <li class="list-inline-item">
                                <span>Position: </span>{{ $search->search}}
                            </li>
                            @endif
                            @if($search->min_salary)
                            <li class="list-inline-item">
                                <span>Min Salary: </span>{{ $search->min_salary??''}}
                            </li>
                            @endif
                            @if($search->max_salary)
                            <li class="list-inline-item">
                                <span>Max Salary: </span>{{ $search->max_salary??''}}
                            </li>
                            @endif

                            @if(isset($search->location))
                            <li class="list-inline-item">
                                @php

                                $location_values_un = unserialize($search->location);
                     
                                             $count = count($location_values_un);

                                    $two_value = array_slice($location_values_un,0,6);

                                    $location_values =  implode(', ', $two_value);


                                @endphp
                              
                                <span>Location: </span>

                              
                                
                             @if($count > 6)
                            {{ $location_values??''}} <span class="mb-0 " style="color: #197ff3;"
                            >More +</span>
                            @else
                            {{ $location_values??''}}
                            @endif


                              
                              



                            </li>
                            @endif

                            @if($search->notice_period)
                            <li class="list-inline-item">
                                <span>Notice Period: </span>
                                @php

                                $notice_period = explode(",", $search->notice_period);


                                @endphp

                                @if(in_array(2, $notice_period) && in_array(1, $notice_period))
                                Immediately Available,Serving NoticePeriod


                                @elseif(in_array(1, $notice_period))
                                Immdiately Available


                                @elseif(in_array(2, $notice_period))
                                Serving NoticePeriod
                                @else

                                @endif



                            </li>
                            @endif

                            <!-- Filter 2 -->
                            @if($search->min_exp)

                            <li class="list-inline-item">
                                <span>Min Experience: </span>{{ $search->min_exp??'' }}
                            </li>
                            @endif

                            @if($search->max_exp)
                            <li class="list-inline-item">
                                <span>Max Experience: </span>{{ $search->max_exp??''}}
                            </li>
                            @endif

                            @if($search->filter_resume)
                            <li class="list-inline-item">
                                <span>Filter Resume: </span>
                                @if($search->filter_resume == 1)
                                Verified Resumes
                                @elseif($search->filter_resume == 2)
                                Unverified Resumes
                                @elseif($search->filter_resume == 3)
                                Express Job Seekers
                                @endif


                            </li>
                            @endif

                            @if($search->interview_avail)
                            <li class="list-inline-item">
                                <span>Interview Availability: </span>{{ $search->interview_avail??''}}
                            </li>
                            @endif

                            @if($search->educationeducation)
                            <li class="list-inline-item">
                                <span>Education: </span>{{ $search->education??'' }}
                            </li>
                            @endif

                            @if($search->course)
                            <li class="list-inline-item">
                                <span>Course: </span>{{ $search->course??''}}
                            </li>
                            @endif

                            @if($search->specilation)
                            <li class="list-inline-item">
                                <span>Specilation: </span>{{ $search->specilation??''}}
                            </li>
                            @endif

                            @if($search->gender)
                            <li class="list-inline-item">
                                <span>Gender: </span>{{ $search->gender??''}}
                            </li>
                            @endif

                            @if($search->job_type)
                            <li class="list-inline-item">
                                <span>Job Type: </span>{{ $search->job_type??''}}
                            </li>
                            @endif

                        </ul>
                        <div class="search-icons cv-search-btns">
                        <a class="btn btn-sent"
                                href="{{ route('search-now',['id'=>$search->id]) }}" target="_blank"><i class="fa fa-search mr-2" aria-hidden="true"></i> Search
                                now</a>
                        </div>
                        <div class="delete-icon">
                            <a class="btn btn-danger" href="{{ route('delete-saved-search',['id'=>$search->id]) }}"><i
                                    class="fa fa-trash text-white" aria-hidden="true"></i></a>
                        </div>

                        <!-- <div class="section_2 pb-0 pt-4 border-top">

                                    <ul class="list-inline">

                                        <li class="list-inline-item mb-1"><a class="candidate_view-more"
                                                href="{{ route('search-now',['id'=>$search->id]) }}" target="_blank">Search
                                                now</a></li>
                                        <li class="list-inline-item mb-1"><a class="btn btn-danger"
                                                href="{{ route('delete-saved-search',['id'=>$search->id]) }}"><i class="fa fa-trash text-white" aria-hidden="true"></i></a></li>

                                    </ul>

                                </div> -->


                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>




@include('includes.footer')



@endsection



@push('scripts')




@endpush