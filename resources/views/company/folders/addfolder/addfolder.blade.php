@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<section class="section_mycollectionss">
    <div class="container">
        {{-- {{$collections}} --}}
        <div class="row">
            <div class="col-12 py-5">
                <div class="box py-4 py-md-5 px-3 px-md-5 rounded">
                    <div class="container">
                        <div class='alert alert-success newclass' id="myElem" style="display:none;">Folder Created Successfully</div>
                    </div>
                    <div class="container">
                        <div class='alert alert-success newclass' id="update_message" style="display:none;">Folder Updated Successfully</div>
                    </div>
                    <div class="container">
                        <!--@if(session()->has('message'))-->
                        <!--    <div class="alert alert-success">-->
                        <!--        {{ session()->get('message') }}-->
                        <!--    </div>-->
                        <!--@endif-->
                    </div>
                    <div class="">
                        <h5 class="px-4 my-0 text_box-align">Folders<span class="collect_twofont mb-2 ml-2">{{count($collections)}}</span>
                        </h5>
                    </div>
                    <hr class="mt-1 mb-4">
                    <div class="row">
                        @foreach ($collections as $item)
                            
                        <div class="col-lg-3 col-md-6 mb-0 mb-md-3">
                            <a class="" href="{{url('collectionsbulkmail',$item->id)}}">
                                <div class="collection_pic-box text-center mt-4 mt-md-0 px-0">
                                    <div class="collection_text">
                                        <div class="collections_text">{{$item->name}}</div>
                                        <?php $count = DB::table('collection_lists')->where('collection_id',$item->id)->get();   ?>
                                        <div class="collections_font mx-auto">{{count($count)}}</div>
                                    </div>
                                </div>
                            </a>
                            <div class="threedots float-right pr-4 pt-4 pt-lg-1">
                                <label class="dropdown">
                                    <i class="fa fa-ellipsis-v radio_point" aria-hidden="true"></i>
                                    <input type="checkbox" class="dd-input" id="test">
                                    <ul class="dd-menu">
                                        <li><a class="py-2 px-3 edit_collection" data-toggle="modal" data-target="#editcollection" data-id="{{$item->id}}">Edit Collection</a></li>
                                        <li><a class="py-2 px-3 delete_collection" data-toggle="modal"data-target="#deletecollection" data-id="{{$item->id}}">Delete Collection</a></li>
                                    </ul>
                                </label>
                            </div>
                        </div>
                        
                        @endforeach
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
<div class="container">
    <!-- modal -->
    <div class="modal" id="editcollection">
        <div class="modal-dialog" id="edit">
            
        </div>
    </div>
</div>
<div class="container">
    <!-- modal -->
    <div class="modal" id="deletecollection">
        <div class="modal-dialog" id="delete">
            
        </div>
    </div>
</div>
<div class="container">
    <!-- modal -->
    <div class="modal" id="create">
        <div class="created_collection modal-dialog">
            <div class="modal-content  mx-auto">
                <!-- header -->
                <div class="modal-header pb-0">
                    <h4 class="modal-title sign_head">Create new folder</h4>
                    <p type="button" class="info" data-dismiss="modal"><img
                            class="float-right modal_close-icon modal_crossarrow" src="asset/images/close.png"></p>
                </div>
                <!-- body -->
                <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <p class="mb-2 py-0 sign_fontsize">Name<span class="text-danger px-1">* </span></p>
                        <input type="text" placeholder="Enter Name" class="px-3 py-2 signup_input w-100 rounded" id="name" requried="" maxlength="100" name="name">
                        <div class="text-danger">
                            <strong id="name-error" class="new_error_class"></strong>
                        </div>
                        <p class="sign_fontsize pt-3 mb-2">Description (optional)</p>
                        <textarea class="form-control" aria-label="With textarea" row="15" cols="50" style="min-height:110px;" name="description" id="description"></textarea>
                    </div>
                    <!-- footer -->
                    <div class="modal-footer">
                        <div class="col-8 col-sm-6">
                            <button type="submit" class="signup_button btn-submit  px-3 py-2 rounded" id="create_folder">Create Collection</button>
                        </div>
                        <div class="col-4 col-sm-6 text-right">
                            <button type="button" class="btn btn btn-secondary py-2" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
@push('scripts')

<script>
    $(document).ready(function(){
        $('#create_folder').click(function(e){
            // alert('hello');
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('store.collection') }}",
                method: 'post',
                data: {
                    _token:"{{ csrf_token() }}",
                    name: $('#name').val(),
                    description: $('#description').val(),
                },
                success: function(result){
                    console.log(result);
                    if(result.success) {
                        window.setTimeout(function(){location.reload()},1000)
                        $('.alert-danger').hide();
                        $('#create').modal('hide');
                        window.location.reload();
                        $("#myElem").show();
                        setTimeout(function() { $("#myElem").hide(); }, 5000);  
                    }
                    if(result.errors)
                    {
                        $('#name-error').html( result.errors[0] );
                    }
                }
            });
        });
    });
</script>

@endpush