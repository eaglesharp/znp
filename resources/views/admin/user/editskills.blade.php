@extends('admin.layouts.admin_layout')
@section('content')
    <style>
        .exampleSearch .select2-container {
            width: 100% !important;

        }

        .exampleSearch .select2-selection {
            height: 100% !important;
            display: flex !important;

        }
    </style>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                    <li> <a href="{{ route('list.users') }}">Users</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Skills</span> </li>
                </ul>
            </div>
            <br />
            @include('flash::message')
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span
                                    class="caption-subject bold uppercase">User Form</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="form-group  kskills " id="div_project_title">
                                    <div class="modal-body ">
                                        <div class='exampleSearch'>
                                            <label class="mb-2 pt-3 sign_fontsize">Mention your key skills<span
                                                    class="text-danger px-1">*</span></label>
                                             <select class="form-control js-example-tokenizer" name="keyskills[]" multiple="multiple" placeholder="Please enter key skills or technologies" id="my-select">
                                           
                                            @foreach($job_skills as $skill)
                                                <option value="{{ $skill->id }}" {{ in_array($skill->job_skill, $keyskills) ? 'selected' : '' }}>{{ $skill->job_skill}}</option>
                                             @endforeach
                                        </select>
                                        </div>
                                        <span class="help-block keyskills-error" style="color:#a94442"></span>
                                    </div>
                                    <p id="success_id105" class="p-success3 px-0"
                                        style="width: 80%;margin-left:80px;color:#36c6d3"></p>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT BODY -->
        </div>
    </div>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.default.css">
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>

    <script type="text/javascript">
        $(".js-example-tokenizer").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        })

        var _token = $('input[name="_token"]').val();
       
        function submitProfileSkillForm() {

            var form = $('#add_edit_profile_skill');

            $.ajax({

                url: form.attr('action'),

                type: form.attr('method'),

                data: form.serialize(),

                dataType: 'json',

                success: function(json) {

                    $("#add_skill_modal").html(json.html);

                    showSkills();



                },

                error: function(json) {

                    if (json.status === 422) {

                        var resJSON = json.responseJSON;

                        $('.help-block').html('');

                        $.each(resJSON.errors, function(key, value) {

                            $('.' + key + '-error').html('<strong>' + value + '</strong>');

                            $('#div_' + key).addClass('has-error');

                        });

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
