@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->


    <section class="postjob-listing py-5 section_empdashboard section_canddashboard">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-12">
                    @if (session('alert'))
                        <div class="alert alert-success">
                            {{ session('alert') }}
                        </div>
                    @endif
                    <h2 class="line_change_1">Applicants List</h2>
                </div>


                @include('company.job.applicant_result')

            </div>
        </div>
    </section>




    @include('includes.footer')
@endsection

@push('scripts')
    <script></script>
@endpush
