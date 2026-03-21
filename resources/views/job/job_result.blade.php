
@foreach ($jobs as $job)
    <div class="col-lg-4 px-2 pt-lg-4 mb-3 m-lg-0">
        <div class="border-job">
           
            <a   href="{{ url('job/'.$job->slug) }}" target="_blank">
                <div class="row">
                    <div class="col-lg-3 text-lg-center text-start col-3 px-lg-0 px-md-3 px-2 col-md-2">
                            @if(isset($job->company->logo))
                            <img src="{{ asset('company_logos/'.$job->company->logo) }}" width="40" height="40"> 
                            @else
                            <img src="{{asset('/')}}asset/images/industry-logo.png" width="40" height="40" style='border-radius: 50%;'>
                            @endif
                       
                    </div>
                    @php
                     $title = $job->job_title;

                    if(strlen($title) > 15)

                    {

                    $title = substr($title, 0, 15) . '...';

                    }
                    @endphp
                    <div class="col-lg-7 col-7 px-lg-0 my-auto px-2 px-md-3 col-md-8">
                        <h3 class="line_change mb-0">{{ $title }} </h3>
                        <h4 class="text-dark">
                             @php
                                $companyName = $job->company->name;
        
                                if(strlen($companyName) > 20){
                                    $companyName = substr($companyName, 0, 20) . '...';
                                }
                                @endphp
                            
                            {{ $companyName ?? '' }}
                            </h4>
                        {{-- <h4 class="text-dark">{{ $job->company->name }} {{ $job->location??'' }} {{ $job->experience??'' }}</h4>
                        @php

                        $sks = [];
                    
                            foreach($job->jobskills as $j)
                            {
                                $sks[] =  $j->job_skill_id;
                            }

                            $jobskills = \App\JobSkill::whereIn('id',$sks)->select('job_skill')->get();
                                                
                    @endphp
                    @foreach ($jobskills as $skill)
                    <li class="list-inline-item">{{ $skill->job_skill }}</li>
                    @endforeach --}}
                    </div>
                    <div class="col-lg-2 col-2 my-auto col-md-1">
                        <i class="fa fa-angle-double-right font-i"></i>
                    </div>
                </div>
            </a> 
        </div>  
    </div>
    @endforeach

    <div class="col-lg-12 pt-3">
        <div class="pagiWrap pb-2">
    
            <nav aria-label="Page navigation example jobpaginate">

                
        
                @if (isset($jobs) && count($jobs))

                @include('vendor.pagination.custom-pagination', ['paginator' => $jobs])
        
                {{-- {{ $jobs->appends(request()->query())->links() }}  --}}
                
                @endif
        
            </nav>
        
        </div>
    </div>

    
   