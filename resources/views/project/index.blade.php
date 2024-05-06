@extends('layouts.master')
@section('title')
    @lang('Projects')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang('Projects')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-9">
            <div class="card" id="invoiceList">
                @if (session('success'))
                    <div class="m-3  alert bg-success alert-dismissible  show" id="alert-success" role="alert">
                        <span class="alert-text text-white">
                            {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                        </button>
                    </div>
                @endif

                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap" id="">
                                <thead class="text-muted">
                                    <tr>

                                        <th class="text-uppercase">#</th>
                                        <th class="text-uppercase">Project Name</th>
                                        <th class="text-uppercase">Consumer Sales</th>
                                        <th class="text-uppercase">Activity Photos</th>
                                        <th class="text-uppercase">Project Type</th>
                                        <th class="text-uppercase">Status</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="">
                                    @forelse ($records as $key => $record)
                                        <tr>
                                            <td>
                                                {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="td">{{ $record->fld_name }}
                                                <p class="text-muted mb-0">
                                                    {{ date(env('DATE_FORMAT'), strtotime($record->fld_start_date)) }}</p>
                                            </td>

                                            <td class="td"> {{ $record->fld_consumer_sales ? 'Yes' : 'No' }}
                                            </td>

                                            <td class="td">{{ $record->fld_activity_photos ? 'Yes' : 'No' }}
                                            </td>

                                            <td class="td">{{ $record->sale_type }}</td>

                                            <td class="td {{ $record->fld_status ? 'text-green' : 'bg-red' }}">
                                                {{ $record->fld_status ? 'Active' : 'Deactive' }}</td>


                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a class=" btn-sm"
                                                        href="{{ route('projects.edit', $record->fld_pid) }}"><i
                                                            class="ri-edit-line"></i></a>
                                                    @if (!count($record->routePlans))
                                                        <form onsubmit="return confirm('Do you really want to delete?');"
                                                            action="{{ route('projects.destroy', $record->fld_pid) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-submit  ri-delete-bin-line">
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a class="ri-file-list-3-line" data-toggle="tooltip"
                                                        data-placement="top" title="Custom Fields"
                                                        href="{{ route('custom-fields.index', ['pid' => $record->fld_pid]) }}"></a>
                                                    <a class="ri-calendar-check-fill" data-toggle="tooltip"
                                                        data-placement="top" title="Summary Question"
                                                        href="{{ route('summaries.index', ['pid' => $record->fld_pid]) }}"></a>

                                                </div>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">
                                                <div class="noresult">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                            trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                                            style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2" style="display: flex;">
                                {{ $records->appends(request()->except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-3">
            @if (request()->route()->getName() === 'projects.edit')
                @include('project.edit', ['project' => $project])
            @else
                @include('project.create')
            @endif

        </div>
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('/build/js/jquery.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
