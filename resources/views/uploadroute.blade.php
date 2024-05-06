@extends('layouts.master')
@section('title')
    @lang('Route Plans')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang('Van Route Plans')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="invoiceList">
                @if (session('success'))
                    <div class="m-3  alert bg-success alert-dismissible  show" id="alert-success" role="alert">
                        <span class="alert-text text-white">
                            {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                        </button>
                    </div>
                @endif

                <div class="card-body  bg-soft-light border border-dashed border-start-0 border-end-0">
                    <form action="{{ route('master.routePlan.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!--end col-->
                            <div class="row">
                                <div class="col-4">
                                    <select id="project_id" name="project_id"
                                        class="form-control bg-light border-light flatpickr-input">
                                        <option value="">Select Project </option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->fld_pid }}" @if($project->fld_pid == 1) selected @endif> {{ $project->fld_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <div>
                                        <input class="form-control" required name="excel" type="file" id="formFile">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="d-flex gap-1">
                                        <button type="submit" class="mr-1 btn btn-primary">Upload</button>
                                        <a target="_blank" href="/uploads/Sample-route-plan-VAN.xlsx"
                                            class="btn btn-info">Download
                                            Sample CSV</a>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap" id="">
                                <thead class="text-muted">
                                    <tr>

                                        <th class="text-uppercase">#</th>
                                        <th class="text-uppercase">Project Name</th>
                                        <th class="text-uppercase">User Name</th>
                                        <th class="text-uppercase">File</th>
                                        <th class="text-uppercase">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="">
                                    @forelse ($records as $key => $record)
                                        <tr>
                                            <td> {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}</a>
                                            </td>
                                            <td class="td">{{ $record->project_name }}</td>
                                            <td class="td">{{ $record->user_name ?? 'NA' }}</td>
                                            <td class="td">
                                                <a href="/{{ $record->fld_file_path }}">{{ $record->fld_file_name }}</a>
                                            </td>

                                            <td class="td">
                                                {{ date(env('DATE_FORMAT', 'd-m-Y'), strtotime($record->fld_created_at)) }}
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
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

                    <!-- Modal -->
                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-labelledby="deleteOrderLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>You are about to delete a user ?</h4>
                                        <p class="text-muted fs-15 mb-4">Deleting your user will remove all of your
                                            information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                    class="ri-close-line me-1 align-middle"></i> Close</button>
                                            <a href="" class="btn btn-danger" id="delete-record">Yes, Delete
                                                It</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->
                </div>
            </div>

        </div>
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".delete_user").click(function(e) {
                let id = $(this).attr('data-id');
                let url = `users/destroy/${id}`;
                $("#delete-record").attr('href', url)
            })
        });
    </script>
@endsection