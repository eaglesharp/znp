@extends('admin.layouts.admin_layout')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                <li> <a href="{{ route('list.jobs', ['company_id' => $company->id]) }}">Jobs</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Add Jobs (Grid)</span> </li>
            </ul>
        </div>

        <h3 class="page-title">Add Jobs <small>{{ $company->name }}</small></h3>

        @if (session('grid_error'))
            <div class="alert alert-danger">{{ session('grid_error') }}</div>
        @endif

        @if (session('grid_failures') && count(session('grid_failures')))
            <div class="alert alert-warning">
                <strong>Some rows need attention:</strong>
                <ul style="margin:6px 0 0;padding-left:18px;">
                    @foreach (session('grid_failures') as $failure)
                        <li>
                            Job {{ $failure['row'] }}{{ !empty($failure['job_title']) ? ' ('.$failure['job_title'].')' : '' }}:
                            {{ implode(' ', $failure['errors'] ?? []) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jobs.grid.store') }}" method="POST" id="jobsGridForm">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <div class="alert alert-info">
                Add one or more jobs for <strong>{{ $company->name }}</strong>. Use the dropdowns and checkboxes to avoid typos.
                Valid jobs are created immediately; invalid ones are reported back so you can fix them.
            </div>

            <div id="jobCards">
                @php $oldJobs = old('jobs'); @endphp
                @if (is_array($oldJobs) && count($oldJobs))
                    @foreach (array_values($oldJobs) as $idx => $oldRow)
                        @include('admin.job._grid_card', ['i' => $idx, 'row' => $oldRow, 'allowedValues' => $allowedValues])
                    @endforeach
                @else
                    @include('admin.job._grid_card', ['i' => 0, 'row' => [], 'allowedValues' => $allowedValues])
                @endif
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-default" id="addJobCard"><i class="fa fa-plus"></i> Add another job</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Create Jobs</button>
                <a href="{{ route('list.jobs', ['company_id' => $company->id]) }}" class="btn btn-link">Cancel</a>
            </div>
        </form>

        <script type="text/template" id="jobCardTemplate">
            @include('admin.job._grid_card', ['i' => '__INDEX__', 'row' => [], 'allowedValues' => $allowedValues])
        </script>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var container = document.getElementById('jobCards');
        var template = document.getElementById('jobCardTemplate').innerHTML;
        var nextIndex = {{ (is_array(old('jobs')) && count(old('jobs'))) ? count(old('jobs')) : 1 }};

        function renumber() {
            var cards = container.querySelectorAll('.job-card');
            cards.forEach(function (card, i) {
                var num = card.querySelector('.job-card-num');
                if (num) { num.textContent = (i + 1); }
                var removeBtn = card.querySelector('.remove-card');
                if (removeBtn) { removeBtn.style.display = cards.length > 1 ? '' : 'none'; }
            });
        }

        function toggleClient(card) {
            var pt = card.querySelector('.posting-type');
            var clientFields = card.querySelector('.client-fields');
            if (!pt || !clientFields) { return; }
            clientFields.style.display = (pt.value === 'client') ? '' : 'none';
        }

        function bindCard(card) {
            toggleClient(card);
            var pt = card.querySelector('.posting-type');
            if (pt) { pt.addEventListener('change', function () { toggleClient(card); }); }
            var removeBtn = card.querySelector('.remove-card');
            if (removeBtn) {
                removeBtn.addEventListener('click', function () {
                    if (container.querySelectorAll('.job-card').length > 1) {
                        card.parentNode.removeChild(card);
                        renumber();
                    }
                });
            }
        }

        document.getElementById('addJobCard').addEventListener('click', function () {
            var html = template.replace(/__INDEX__/g, nextIndex);
            nextIndex++;
            var wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            var card = wrapper.firstElementChild;
            container.appendChild(card);
            bindCard(card);
            renumber();
        });

        container.querySelectorAll('.job-card').forEach(bindCard);
        renumber();
    })();
</script>
@endpush
