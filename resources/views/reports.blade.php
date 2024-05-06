@extends('layouts.master')
@section('title')
    @lang('Reports')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang('Reports')
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
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"> @lang('Reports')</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-success"><i class="ri-file-2-line h-6 w-6"></i> Route Plan </a>
                            <a class="btn btn-success"><i class="ri-file-2-line h-6 w-6"></i> Day Wise Sales summary
                            </a>
                            <a class="btn btn-success"><i class="ri-file-2-line h-6 w-6"></i> Stock Report</a>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-soft-light border border-dashed border-start-0 border-end-0">
                    <form action="{{ url('Reports') }}" method="GET">
                        <div class="row g-3">
                            <!--end col-->
                            <div class="col">
                                <select name="project_id" class="form-control bg-light border-light flatpickr-input">
                                    <option value="">@lang('Project') </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="posting" class="form-control bg-light border-light flatpickr-input">
                                    <option value="">@lang('State') </option>
                                    <option value="1" @selected(request('posting') == 1)>@lang('HO')</option>
                                    <option value="2" @selected(request('posting') == 2)>@lang('district')</option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="posting" class="form-control bg-light border-light flatpickr-input">
                                    <option value="">@lang('District') </option>
                                    <option value="1" @selected(request('posting') == 1)>@lang('HO')</option>
                                    <option value="2" @selected(request('posting') == 2)>@lang('district')</option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="posting" class="form-control bg-light border-light flatpickr-input">
                                    <option value="">@lang('Users') </option>
                                </select>
                            </div>
                            <!--end col-->
                            <div class="col">
                                <input name="start_date" type="date"
                                    class="form-control bg-light border-light flatpickr-input" id="start_date"
                                    placeholder="@lang('start date')" value="{{ request('start_date') }}">
                            </div>
                            <div class="col">
                                <input name="end_date" type="date"
                                    class="form-control bg-light border-light flatpickr-input" id="end_date"
                                    placeholder="@lang('End date')" value="{{ request('end_date') }}">
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
                                        <th class="text-uppercase">Consumer</th>
                                        <th class="text-uppercase">User</th>
                                        <th class="text-uppercase">Project Name</th>
                                        <th class="text-uppercase">State</th>
                                        <th class="text-uppercase">District</th>
                                        <th class="text-uppercase">Tehsil</th>
                                        <th class="text-uppercase">Date</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="">
                                    @foreach ($records as $key => $record)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="td">{{ $record->fld_cid }}</td>
                                            <td class="td">{{ $record->fld_user }}</td>
                                            <td class="td">{{ $record->fld_pid }}</td>
                                            <td class="td">{{ $record->fld_state_id }}</td>
                                            <td class="td">{{ $record->fld_district_id }}</td>
                                            <td class="td">{{ $record->fld_tehsil_id }}</td>
                                            <td class="td">
                                                {{ date(env('DATE_FORMAT'), strtotime($record->fld_date)) }}</td>

                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><button class="dropdown-item" href="javascript:void(0);"
                                                                onclick="ViewInvoice(this);" data-id="25000351"><i
                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                @lang('translation.view')</button></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('reports', $record->fld_id) }}"
                                                                data-id="25000351">
                                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                @lang('translation.edit')</a>
                                                        </li>
                                                        <li class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item remove-item-btn delete_user"
                                                                data-bs-toggle="modal" href="#deleteOrder"
                                                                data-id={{ $record->fld_id }}>
                                                                <i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                @lang('translation.delete')
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ invoices We did not find any
                                        invoices for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2" style="display: flex;">
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
