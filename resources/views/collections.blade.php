@extends('layouts.app')

@section('content') 

<!-- Header start --> 

@include('includes.header') 

<section class="section_mycollections">
    <div class="container">
        <div class="row">
            <div class="col-12 py-5">
                <div class="box py-4 py-md-5 px-3 px-md-5 rounded">
                    <div class="">
                        <h5 class="px-4 my-0 text_box-align">Folders<span class="collect_twofont mb-2 ml-2">3</span>
                        </h5>
                    </div>
                    <hr class="mt-1 mb-4">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-0 mb-md-3">
                            <a class="" href="inneremails.php">
                                <div class="collection_pic-box text-center mt-4 mt-md-0 px-0">
                                    <div class="collection_text">
                                        <div class="collections_text">Interface</div>
                                        <div class="collections_font mx-auto">66</div>
                                    </div>
                                </div>
                            </a>
                            <div class="threedots float-right pr-4 pt-4 pt-lg-1">
                                <label class="dropdown">
                                    <i class="fa fa-ellipsis-v radio_point" aria-hidden="true"></i>
                                    <input type="checkbox" class="dd-input" id="test">
                                    <ul class="dd-menu">
                                        <li><a class="py-2 px-3" data-toggle="modal" data-target="#editcollection">Edit
                                                Collection</a></li>
                                        <li><a class="py-2 px-3" data-toggle="modal"
                                                data-target="#deletecollection">Delete
                                                Collection</a></li>
                                    </ul>
                                </label>
                            </div>
                        </div>
                       
                       
                        <div class="col-lg-3 col-md-6">
                            <a href="javascript:void(0)" class="plus_collection" data-toggle="modal"
                                data-target="#create">
                                <div class="create_collection plus_collection px-0 mt-4 mt-md-0">
                                    +
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- modals -->
<!--<div class="container">-->
<!--    <div class="modal" id="mymodal">-->
<!--        <div class="modal-dialog">-->
<!--            <div class="modal-content mx-auto py-2">-->
<!--                <div class="modal-header pb-0">-->
<!--                    <h4 class="modal-title sign_head">Add this to collections</h4>-->
<!--                    <p type="button" class="info" data-dismiss="modal"><img-->
<!--                            class="float-right modal_close-icon modal_crossarrow" src="asset/images/cancel.png"></p>-->
<!--                </div>-->
<!--                <div class="modal-body ">-->
<!--                    <form>-->
<!--                        <input type="text" placeholder="Filter collections"-->
<!--                            class="px-3 py-2 signup_input w-100 rounded">-->
<!--                    </form>-->
<!--                    <div class="filter_scrollbar">-->
<!--                        <a href="javascript:void()">-->
<!--                            <div class="filter_collection-saved rounded mt-2 py-2">-->
<!--                                <div class="row px-3">-->
<!--                                    <div class="col-12 px-3">-->
<!--                                        <h6 class="sign_head mb-0">Php Interface</h6>-->
<!--                                        <p class="my-0 modal-filter_font">1 Collection</p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                        <a href="javascript:void()">-->
<!--                            <div class="filter_collection-saved rounded mt-2 py-2">-->
<!--                                <div class="row px-3">-->
<!--                                    <div class="col-12 px-3">-->
<!--                                        <h6 class="sign_head mb-0">Php Interface</h6>-->
<!--                                        <p class="my-0 modal-filter_font">2 Collection</p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </div>-->

<!--                </div>-->
<!--                <div class="modal-footer">-->
<!--                    <div class="col-8 col-sm-6">-->
<!--                        <button type="button" class="signin_button  px-3 py-2 rounded" data-toggle="modal"-->
<!--                            data-target="#create">Create New Collection</button>-->
<!--                    </div>-->
<!--                    <div class="col-4 col-sm-6 text-right">-->
<!--                        <button type="button" class="btn btn btn-primary py-2" data-dismiss="modal">Done</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<div class="container">
    <!-- modal -->
    <div class="modal" id="editcollection">
        <div class="modal-dialog">
            <div class="modal-content mx-auto py-2">
                <!-- header -->
                <div class="modal-header pb-0">
                    <h4 class="modal-title sign_head">Edit collection</h4>
                    <p type="button" class="info" data-dismiss="modal"><img
                            class="float-right modal_close-icon modal_crossarrow" src="asset/images/cancel.png"></p>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <form>
                        <p class="mb-2 py-0 sign_fontsize">Name<span class="text-danger px-1">* </span></p>
                        <input type="text" placeholder="Enter Name" class="px-3 py-2 signup_input w-100 rounded"
                            requried maxlength="100" minlength="5">
                        <p class="sign_fontsize pt-3 mb-2">Description (optional)</p>
                        <textarea class="form-control" aria-label="With textarea" row="10" cols="50"></textarea>
                    </form>
                </div>
                <!-- footer -->
                <div class="modal-footer">
                    <div class="col-6">
                        <button type="submit" class="signin_button  px-3 py-2 rounded">Update</button>
                    </div>
                    <div class="col-6 text-right">
                        <button type="button" class="btn btn btn-secondary py-2" data-dismiss="modal">cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <!-- modal -->
    <div class="modal" id="deletecollection">
        <div class="modal-dialog">
            <div class="modal-content mx-auto py-2">
                <!-- header -->
                <div class="modal-header justify-content-end pb-0">
                    <p type="button" class="info" data-dismiss="modal"><img
                            class="float-right modal_close-icon modal_crossarrow" src="asset/images/cancel.png"></p>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <p class="sign_head">Do you want to Delete this Collection ?</p>
                </div>
                <div class="modal-footer justify-content-end px-3">
                    <button type="button" class="signup_button px-4 py-2 rounded mr-2">Ok</button>
                    <button type="button" class="btn btn-secondary py-2" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <!-- modal -->
    <div class="modal" id="create">
        <div class="created_collection modal-dialog">
            <div class="modal-content  mx-auto py-2">
                <!-- header -->
                <div class="modal-header pb-0">
                    <h4 class="modal-title sign_head">Create new collections</h4>
                    <p type="button" class="info" data-dismiss="modal"><img
                            class="float-right modal_close-icon modal_crossarrow" src="asset/images/cancel.png"></p>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <form>
                        <p class="mb-2 py-0 sign_fontsize">Name<span class="text-danger px-1">* </span></p>
                        <input type="text" placeholder="Enter Name" class="px-3 py-2 signup_input w-100 rounded"
                            requried maxlength="100" minlength="5">
                        <p class="sign_fontsize pt-3 mb-2">Description (optional)</p>
                        <textarea class="form-control" aria-label="With textarea" row="15" cols="50"
                            style="min-height:110px;"></textarea>
                    </form>
                </div>
                <!-- footer -->
                <div class="modal-footer">
                    <div class="col-8 col-sm-6">
                        <button type="submit" class="signup_button  px-3 py-2 rounded">Create Collection</button>
                    </div>
                    <div class="col-4 col-sm-6 text-right">
                        <button type="button" class="btn btn btn-secondary py-2" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <!-- Header end --> 

<!-- Inner Page Title start --> 

@include('includes.inner_page_title', ['page_title'=>__('Collections')]) 

<!-- Inner Page Title end -->

<div class="listpgWraper">

    <div class="container">@include('flash::message')

        <div class="row"> @include('includes.company_dashboard_menu')

            <div class="col-md-9 col-sm-8">

                <div class="myads">
                    <h3>{{__('Collections')}}</h3>
                    <ul class="searchList">
                        <!-- job start --> 
                        @if(isset($collections) && count($collections))
                        @foreach($collections as $collection)
                       
                      
                        <li id="job_li_{{$collection->id}}">
                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                            
                                    <div class="jobinfo">
                                        <h3>{{$collection->name??''}}</h3>
                                     
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-4 col-sm-4">                
                                    <div class="listbtn"><a href="{{route('company.collectionsbulkmail', [$collection->id])}}">{{__('Mail')}}</a></div>
                                    <div class="listbtn"><a href="{{route('edit.collection', [$collection->id])}}">{{__('Edit')}}</a></div>
                                    <div class="listbtn"><a href="javascript:;" onclick="deleteJob({{$collection->id}});">{{__('Delete')}}</a></div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    <div class="pagiWrap">

                        <div class="row">

                            <div class="col-md-5">

                                <div class="showreslt">

                                    {{__('Showing Pages')}} : {{ $collections->firstItem() }} - {{ $collections->lastItem() }} {{__('Total')}} {{ $collections->total() }}

                                </div>

                            </div>

                            <div class="col-md-7 text-right">

                                @if(isset($collections) && count($collections))

                                {{ $collections->appends(request()->query())->links() }}

                                @endif

                            </div>

                        </div>

                    </div>
                </div>


        </div>

        </div>

    </div>

</div> --}}

@include('includes.footer')

@endsection

@push('scripts')

@include('includes.immediate_available_btn')

@endpush

