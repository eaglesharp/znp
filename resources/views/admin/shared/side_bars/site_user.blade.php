<li class="nav-item  "> <a href="javascript:;" class="nav-link nav-toggle"> <i class="icon-user"></i> <span class="title">User Profiles</span> <span class="arrow"></span> </a>
    <ul class="sub-menu">
        <li class="nav-item  "> <a href="{{ route('list.users') }}" class="nav-link "> <i class="icon-user"></i> <span class="title">List User Profiles</span> </a> </li>
        <li class="nav-item  "> <a href="{{ route('create.user') }}" class="nav-link "> <i class="icon-user"></i> <span class="title">Add new User Profile</span> </a> </li>
        <li class="nav-item  "> <a href="{{ route('hide.users') }}" class="nav-link "> <i class="icon-user"></i> <span class="title">Hidden User Profiles</span> </a> </li>
        <!--@if(APAuthHelp::check(['SUP_ADM']))-->
        <li class="nav-item  "> <a href="{{ route('bulkuseruploads') }}" class="nav-link "> <i class="icon-user"></i> <span class="title">Bulk User</span> </a> </li>
        <!--@endif-->
        @if (Auth::user()->role_id == 1)
        <li class="nav-item  "> <a href="{{ route('candidate.payment.history') }}" class="nav-link "> <i class="icon-user"></i> <span class="title">Payment History</span> </a> </li>
        @endif
             <li class="nav-item  "> <a href="{{ route('bulkuseruploads') }}" class="nav-link "> <i class="icon-user"></i> <span class="title">Bulk User</span> </a> </li>

    </ul>
</li>