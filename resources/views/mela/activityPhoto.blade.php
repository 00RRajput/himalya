@extends('layouts.master')
@section('title')
    @lang('Activity Photos')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang('Mela Activity Photos')
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
                <div class="card-body bg-soft-light border border-dashed border-start-0 border-end-0">
                    <form action="{{ url('/mandi/activity-photos') }}" method="GET">
                        <div class="row g-3">
                            <!--end col-->
                            <div class="col">
                                <select id="project_id" name="project_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">Select Project </option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->fld_pid }}" @selected(session('project_id') == $project->fld_pid || request('project_id') == $project->fld_pid)>
                                            {{ $project->fld_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select id="state_id" name="state_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">All States</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->fld_sid }}" @selected(request('state_id') == $state->fld_sid)>
                                            {{ $state->fld_state }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select name="district_id" id="district_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">@lang('All Districts') </option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->fld_did }}" @selected(request('district_id') == $district->fld_did)>
                                            {{ $district->fld_district }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select name="user_id" class="form-control bg-light border-light flatpickr-input">
                                    <option value="">@lang('All Field Users') </option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->fld_uid }}" @selected(request('user_id') == $user->fld_uid)>
                                            {{ $user->fld_name }}</option>
                                    @endforeach
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
                            <div class="col">
                                <div class="d-flex gap-2">
                                    <button type="submit" name="submit" name="go"
                                        class="col  mr-1 btn btn-primary">Search</button>
                                    <button type="submit" name="submit" value="reset"
                                        class="col  mr-1 btn btn-secondary ">Reset</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="row mt-1" id="seller-list">
                            @forelse ($records as $record)
                                <div class="col-lg-2">
                                    <a class="image-popup m-0 p-0"
                                        href="{{ env('SERVER_BASE_URL') }}{{ $record->fld_path }}/{{ $record->fld_image }}"
                                        title="">
                                        <img class="gallery-img img-fluid mx-auto"
                                            src="{{ env('SERVER_BASE_URL') }}{{ $record->fld_path }}/{{ $record->fld_image }}"
                                            alt="">
                                        <div class="gallery-overlay">
                                            <h5 class="overlay-caption">{{ $record->photo_type }}</h5>
                                        </div>
                                    </a>
                                    <p class="text-muted m-0 p-0">
                                        {{ date(env('DATE_FORMAT'), strtotime($record->fld_created_at)) }}
                                        <a href="http://maps.google.com/?q={{ $record->fld_lat }},{{ $record->fld_long }}"
                                            target="_blank" class="ri-map-pin-fill"></a>

                                    </p>
                                    <p class="m-0 p-0 text-muted">{{ $record->user_name }} |
                                        {{ $record->user->state->fld_state ?? 'NA' }}</p>
                                    <p class="text-muted">{{ $record->project_name ?? '' }}</p>

                                </div>
                            @empty
                                <div class="noresult">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>

                                    </div>
                                </div>
                            @endforelse

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
