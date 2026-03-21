@extends('admin.layouts.admin_layout')
@section('content')
<style>
    .data{
        margin-top: 30px
    }
    .pd{
        padding-right: 30px
    }
    .mt-50{
        padding-top: 50px
    }
</style>

<div class="page-content-wrapper"> 
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Employer Activities</span> </li>
            </ul>
        </div>
       @php
           $companies = \App\Company::latest()->get();
           
           
          
       @endphp
       
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    
                    <div class="portlet-body">
                        <div class="row">
                            <form id="usersdata" action="{{ route('get-company-data') }}" method="post">
                                @csrf
                                   <label>Select Employer</label>
                                    <select class="form-control col-10" name="user">
                                        <option selected value="all">All</option>
                                        @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->email }}</option>
                                    @endforeach
                    
                                    </select>
                                    <button type="submit" class="btn btn-primary"  style="margin-top:10px">Submit</button>
                                </form>
                            {{-- <div class="col-lg-2">
                              <span>Select Employer</span>
                            </div>
                            <div class="col-lg-8">
                                <select class="form-control">
                                    <option disabled selected>Select</option>
                                    @foreach($companies as $company)
                                    <option>{{ $company->email }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </div>

                      

                        @foreach($companies as $companydata)

                        @php
                            $plan = \App\Package::where('id',$companydata->package_id)->first();
                            $activities = \App\CompanyActivity::where('company_id',$companydata->id)->latest()->get();
                        @endphp
         <div class="row">
           
            <div class="content" style="margin-top: 50px"> 
          
                <div class="col-md-4  col-sm-4">

                    <div class="portlet light bordered">

                        <div class="portlet-title">

                            <div class="caption"> <i class="icon-share font-dark hide"></i> <span class="caption-subject font-dark bold uppercase">Login Details</span> </div>
    
                        </div>

                        <div class="portlet-body">

                            <div class="slimScrol">

                                <ul class="feeds">

                                    @foreach($activities as $company)

                                    

                                    <li>

                                        <div class="col1">

                                            <div class="cont">

                                                <div class="cont-col1">

                                                    <div class="label label-sm label-info"> <i class="fa fa-check"></i> </div>

                                                </div>

                                                <div class="cont-col2">

                                                    <div class="desc">Login at : {{ \Carbon\Carbon::parse($company->date)->format('d/m/Y')??'' }} - {{ $company->location??'' }} {{ \Carbon\Carbon::parse($company->date)->format('h:ia')??'' }}</div>

                                                </div>

                                            </div>

                                        </div>

                                    </li>

                                    @endforeach

                                </ul>

                            </div>

                            

                        </div>

                    </div>

                </div>
                <div class="col-md-8">
                    <div class="mt-3 p-4" style="border: 1px solid #e1e1e1;padding: 30px 20px;min-height: 343px;">
                        <div style="display: flex;flex-wrap: wrap;">
                            <p class="caption-subject font-dark bold  pd">Company Name: {{ $companydata->name??'' }} </p> 
                            {{-- <p class="caption-subject font-dark bold  pd">Location: Chennai </p> --}}

                            <p class="caption-subject font-dark bold  pd">Plan: {{ $plan->package_title??'' }} </p>
                            <p class="caption-subject font-dark bold  pd">Subscription Date: @if($companydata->package_start_date){{ \Carbon\Carbon::parse($companydata->package_start_date)->format('d/m/Y')??'' }}@endif</p>
                            <p class="caption-subject font-dark bold  pd">End date: @if($companydata->package_end_date){{ \Carbon\Carbon::parse($companydata->package_end_date)->format('d/m/Y')??'' }} @endif </p>

                            <p class="caption-subject font-dark bold  pd"><a href="{{ route('edit.company', $companydata->id) }}"> View All </a></p>
                        </div>
                        <div class="row" style="padding-top: 50px;">
                            <div class="col-sm-4  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 red" href="#">

                                <div class="visual"> <i class="fa fa-user"></i> </div>
        
                                <div class="details">
        
                                    <div class="number"> <span data-counter="counterup" data-value="1349">{{$companydata->cvs_quota??0}}</span> </div>
        
                                    <div class="desc"> No of CV Access </div>
        
                                </div>
        
                            </a> </div>
                            <div class="col-sm-4  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 red" href="#">

                                <div class="visual"> <i class="fa fa-user"></i> </div>
        
                                <div class="details">
        
                                    <div class="number"> <span data-counter="counterup" data-value="1349">{{$companydata->no_of_downloads??0}}</span> </div>
        
                                    <div class="desc"> No of Downloads </div>
        
                                </div>
        
                            </a> </div>
                            <div class="col-sm-4  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 red" href="#">

                                <div class="visual"> <i class="fa fa-user"></i> </div>
        
                                <div class="details">
        
                                    <div class="number"> <span data-counter="counterup" data-value="1349">{{$companydata->email_quota??0}}</span> </div>
        
                                    <div class="desc"> No of Email Sent </div>
        
                                </div>
        
                            </a> </div>
                        </div>
                    </div>
                </div>

            </div>

           

         </div>
         @endforeach
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY --> 
</div>
@endsection
@push('scripts')

<script type="text/javascript">

    $(function () {

        $('.slimScrol').slimScroll({

            height: '250px',

            railVisible: true,

            alwaysVisible: true

        });

    });

    </script>
    @endpush
