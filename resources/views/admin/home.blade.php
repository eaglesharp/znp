@extends('admin.layouts.admin_layout')

@section('content')

<div class="page-content-wrapper"> 

    <!-- BEGIN CONTENT BODY -->

    <div class="page-content" style="background-color:#eef1f5;"> 

        <!-- BEGIN PAGE HEADER-->     

        <!-- BEGIN PAGE BAR -->

        <div class="page-bar">

            <ul class="page-breadcrumb">

                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>

                <li> <span>{{ $siteSetting->site_name }} Admin Panel</span> </li>

            </ul>

        </div>

        <!-- END PAGE BAR --> 

        <!-- BEGIN PAGE TITLE-->

        <h3 class="page-title"> Candidate Activities </h3>

        <!-- END PAGE TITLE--> 

        <!-- END PAGE HEADER-->

        <div class="row">

            <div class="col-lg-12">

                <div class="col-sm-3  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 green" href="#">

                        <div class="visual"> <i class="fa fa-user"></i> </div>

                        <div class="details">

                            <div class="number"> <span data-counter="counterup" data-value="1349">{{ $totalTodaysUsers }}</span> </div>

                            <div class="desc">Registered Candidates </div>

                        </div>

                    </a> </div>

                <div class="col-sm-3  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 red" href="#">

                        <div class="visual"> <i class="fa fa-user"></i> </div>

                        <div class="details">

                            <div class="number"> <span data-counter="counterup" data-value="1349">{{ $totalActiveUsers }}</span> </div>

                            <div class="desc"> Active Candidates </div>

                        </div>

                    </a> </div>

                    <div class="col-sm-3  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 red" href="#">

                        <div class="visual"> <i class="fa fa-user"></i> </div>

                        <div class="details">

                            <div class="number"> <span data-counter="counterup" data-value="1349">{{ $totalnonActiveUsers }}</span> </div>

                            <div class="desc"> InActive Candidates </div>

                        </div>

                    </a> </div>

                <div class="col-sm-3  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#">

                        <div class="visual"> <i class="fa fa-user"></i> </div>

                        <div class="details">

                            <div class="number"> <span data-counter="counterup" data-value="1349">{{ $totalVerifiedUsers }}</span> </div>

                            <div class="desc"> Verified Candidates </div>

                        </div>

                    </a>
                 </div>
                 
                <div class="col-sm-3  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#">

                    <div class="visual"> <i class="fa fa-user"></i> </div>

                    <div class="details">

                        <div class="number"> <span data-counter="counterup" data-value="1349">{{ $totalnonVerifiedUsers }}</span> </div>

                        <div class="desc">Non Verified Candidates </div>

                    </div>

                </a>
             </div>
                 <div class="col-sm-3  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#">

                    <div class="visual"> <i class="fa fa-user"></i> </div>

                    <div class="details">

                        <div class="number"> <span data-counter="counterup" data-value="1349">{{ $totalitusers }}</span> </div>

                        <div class="desc"> IT </div>

                    </div>

                </a>
             </div>
             <div class="col-sm-3  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#">

                <div class="visual"> <i class="fa fa-user"></i> </div>

                <div class="details">

                    <div class="number"> <span data-counter="counterup" data-value="1349">{{ $totalnonitusers }}</span> </div>

                    <div class="desc"> NON-IT </div>

                </div>

            </a>
         </div>

            </div>

        </div>
        <div class="row" style="
    margin-top: 40px;
    margin-bottom: 40px;
">
   <div class="col-lg-6 my-3">
        <form id="usersdata" action="{{ route('get-user-data') }}" method="post">
            @csrf
               <label>Select User</label>
                <select class="form-control col-10" name="user">
                    <option selected disabled>Select</option>
                    @foreach($users as $recentUser)
                    <option value="{{ $recentUser->id }}">{{ $recentUser->email }}</option>
                    @endforeach

                </select>
                <button type="button" class="btn btn-primary" onclick="getdata();" style="margin-top:10px">Submit</button>
            </form>
    </div>

    <div class="col-lg-6">

             <div class="col-sm-4  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#">

                <div class="visual"> <i class="fa fa-user"></i> </div>

                <div class="details">

                    <div class="number"> <span id="downloads">0</span> </div>

                    <div class="desc">No of Downloads</div>

                </div>

            </a>
         </div>
         <div class="col-sm-4  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#">

                <div class="visual"> <i class="fa fa-user"></i> </div>

                <div class="details">

                    <div class="number"> <span id="emails">0</span></div>

                    <div class="desc">No of Emails</div>

                </div>

            </a>
         </div>
         <div class="col-sm-4  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#">

                <div class="visual"> <i class="fa fa-user"></i> </div>

                <div class="details">

                    <div class="number"> <span id="views">0</span> </div>

                    <div class="desc">No of Views</div>

                </div>

            </a>
         </div>
    </div>
    </div>

        @if (Auth::user()->role_id == 1)
        <h3 class="page-title"> Employer Activities </h3>

        <!-- END PAGE TITLE--> 

        <!-- END PAGE HEADER-->

        <div class="row">

            <div class="col-lg-12">

                <div class="col-sm-3  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 green" href="#">

                        <div class="visual"> <i class="fa fa-user"></i> </div>

                        <div class="details">

                            <div class="number"> <span data-counter="counterup" data-value="1349">{{ $totalEmployers }}</span> </div>

                            <div class="desc">Registered Employers </div>

                        </div>

                    </a> </div>

                <div class="col-sm-3  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 red" href="#">

                        <div class="visual"> <i class="fa fa-user"></i> </div>

                        <div class="details">

                            <div class="number"> <span data-counter="counterup" data-value="1349">{{ $totalActiveEmployers }}</span> </div>

                            <div class="desc"> Active Employers </div>

                        </div>

                    </a> </div>

                    <div class="col-sm-3  colg-lg-4 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 red" href="#">

                        <div class="visual"> <i class="fa fa-user"></i> </div>

                        <div class="details">

                            <div class="number"> <span data-counter="counterup" data-value="1349">{{ $totalnonActiveEmployers }}</span> </div>

                            <div class="desc"> InActive Employers </div>

                        </div>

                    </a> </div>

                
                
             

            </div>

        </div>

        <div class="row">

            <div class="col-md-6 col-sm-6">

                <div class="portlet light bordered">

                    <div class="portlet-title">

                        <div class="caption"> <i class="icon-share font-dark hide"></i> <span class="caption-subject font-dark bold uppercase">Recent Registered Employers</span> </div>

                    </div>

                    <div class="portlet-body">

                        <div class="slimScrol">

                            <ul class="feeds">

                                @foreach($recentEmployers as $recentEmployer)

                                <li>

                                    <div class="col1">

                                        <div class="cont">

                                            <div class="cont-col1">

                                                <div class="label label-sm label-info"> <i class="fa fa-check"></i> </div>

                                            </div>

                                            <div class="cont-col2">

                                                <div class="desc"><a href="{{ route('edit.company', $recentEmployer->id) }}"> {{ $recentEmployer->name }} ({{ $recentEmployer->email }}) </a>  - <i class="fa fa-home" aria-hidden="true"></i></div>

                                            </div>

                                        </div>

                                    </div>

                                </li>

                                @endforeach

                            </ul>

                        </div>

                        <div class="scroller-footer">

                            <div class="btn-arrow-link pull-right"> <a href="{{ route('list.companies') }}">See All Employers</a> <i class="icon-arrow-right"></i> </div>

                        </div>

                    </div>

                </div>

            </div>
            <div class="col-md-6">
                <div class=" mt-3" style="margin-top: 27px">
                    <span class="caption-subject font-dark bold uppercase">Package Details </span> 
                    <canvas id="myChart"></canvas>
                  </div>
            </div>


        </div>
        @endif

    </div>

    <!-- END CONTENT BODY --> 

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js"></script>


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

    var ctx = document.getElementById("myChart");
var data = {
    datasets: [{
        data: [{{ $trail }}, {{ $basic }}, {{ $standard }}, {{ $premium }},],
        backgroundColor: [
            "#2ecc71",
        "#3498db",
        "#95a5a6",
        "#9b59b6",
       
        ],
        label: 'My dataset' // for legend
    }],
    labels: ["Trail", "Basic", "Standard", "Premium"]
};
var pieChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItems, data) {
                    return data.labels[tooltipItems.index] + 
                    " : " + 
                    data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] +
                    ' ';
                }
            }
        }
    }
});

    


 function getdata() {
 var form = $('#usersdata');
    $.ajax({
    url     : form.attr('action'),
            type    : form.attr('method'),
            data    : form.serialize(),
            dataType: 'json',
            success : function (json){
               // alert(json.user.no_of_downloads);
              $("#register_date").html(json.user.id);
              $("#downloads").html(json.user.no_of_downloads);
              $("#emails").html(json.user.no_of_emails);
               $("#views").html(json.user.no_profile_views);
             // $("#register_date").html(json.user.id);
            // $('#register_date').val(json.user.id);
            },
            error: function(json){
            if (json.status === 422) {
           alert('error');
            } else {
            // Error
            // Incorrect credentials
            // alert('Incorrect credentials. Please try again.')
            }
            }
    });
    }
</script>

@endpush