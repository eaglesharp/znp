@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 



<section class="postjob-listing py-5">
    <div class="container">

        <div class="row">
            <div class="col-lg-10 col-6">
                    <h2 class="line_change_1">Posted Jobs</h2>
            </div>
            <div class="col-lg-2 col-6">
            <a href="{{ url('post-job') }}"><button type="submit" class="btn btn-sent mb-2 mb-sm-0 mr-2">Post Job</button></a>
            </div>
        </div>
        <div class="row justify-content-center">
           @forelse ($jobs as $job)
           <div class="col-lg-4 pr-4" id="job_li_{{$job->id}}">
            <div class="row boxing rounded justify-content-center bg-white mt-4">
                <div class="col-10 px-2  pt-3 select_input_cus bg-white">
                    <ul class="list-inline job_view">
                        <p class="mb-0"><a href="{{ url('job/'.$job->slug) }}" target="_blank" rel="" class="line_change">{{ $job->job_title }}</a></p>
                        <p class="m-0 text-muted font-weight-bold">{{ auth()->guard('company')->user()->name }}</p>
                       
                        @php
                         $result = null;

                        try {
                        if($job->location != NULL )
                        {
                            $loc = unserialize($job->location);
                            $values = array_values($loc);
                            $result = implode(',', $values);
                            }
                        } catch (Exception $e) {
                            // Handle the exception here
                          
                        }
                                                
                        @endphp
                   @if ( $result)
                   <p class="text-muted font-weight-bold">{{ $result??'' }}</p>
                   @endif
                   
                    
                        
                        <li><span>Job Type:</span>{{ $job->job_type??'' }}</li>
                        <li><span>Salary Range:</span>{{ $job->min_salary??'' }}lakh - {{ $job->max_salary??'' }}lakh</li>
                        <li><span>Experience:</span>{{ $job->experience??'' }}</li>
                        <li><span>Number Of Openings:</span>{{ $job->no_of_openings??"" }}</li>
                    </ul>
                </div>
                <div class="col-2 pl-0 pt-3 mt-3 cv-search-btns">
                    <input class='input-switch toggle-class' type="checkbox" id="demo-{{$job->id}}" data-id="{{$job->id}}" data-on="Active" data-off="InActive" {{ $job->status ? 'checked' : '' }}/>
                    <label class="label-switch" for="demo-{{$job->id}}"></label>
                </div>

                <div class="col-12 d-flex pt-3 justify-content-between px-2">
                    <a href="{{ route('view.applicants.list',$job->id) }}"><button type="submit" class="btn btn-sent-1 mb-2 mr-2">View Applicants <span class="text-light">({{ $job->applied_users_count??'' }})</span></button></a>
                    <ul class="list-inline-item text-right pt-2">
                        <li class="list-inline-item edit"><a href="{{ route('edit.front.job',$job->id) }}"><i class="fa fa-pencil"></i></a></li>
                        <li class="list-inline-item edit"><a href="{{ route('clone.front.job',$job->id) }}"><i class="fa fa-clone"></i></a></li>
                    
                        <li class="list-inline-item trash"><a onclick="deleteJob({{ $job->id }})"><i class="fa fa-trash-o"></i></a></li>
                  
                    </ul>
                </div>
                <div class="col-12 text-right">
                    <ul class="date">
                        <li class="list-inline-item"><span>Posted Date : </span>{{ \Carbon\Carbon::parse($job->created_at)->format('d-m-Y')  }}</li>
                    </ul>
                </div>
            </div>
        </div>
        @empty

        <h1 class="text-center">No Jobs</h1>

           @endforelse
           
         
        </div>
    </div>
</section>




@include('includes.footer')


@push('scripts')



<script>
       

    $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var job_id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('make.active.job') }}",
            data: {'status': status, 'job_id': job_id},
            success: function(data){
                toastr.success(data.success);
                console.log(data.success)
            }
        });
    })
  })


  function deleteJob(id) {
    var msg = 'Are you sure?';
    if (confirm(msg)) {
    $.post("{{ route('delete.front.job') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            if (response == 'ok')
            {
            $('#job_li_' + id).remove();
            toastr.success("Job Deleted Successfully");
            } else
            {
                $('#job_li_' + id).remove();
            toastr.success("Job Deleted Successfully");
            }
            });
    }
    }
</script>
@endpush
@endsection