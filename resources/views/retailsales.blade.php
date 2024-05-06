@extends('layouts.master')
@section('title')
    @lang('Van Retails Sales')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('titleHeading')
            {{$retailerName ?? 'VAN'}} RETAILS SALES (Total Orders: {{ $records->total() }} , Order Value: ₹ {{ $total_order_value }})
        @endslot
        @slot('title')
            VAN RETAILS SALES
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
                    <form action="{{ url('/van/retail-sales') }}" method="GET">
                        <div class="row g-3">
                            <!--end col-->
                            <div class="col">
                                <select id="project_id" name="project_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <!-- <option value="">All Projects </option> -->
                                    @foreach ($projects as $project)
                                    @if($project->fld_pid ==1 )<option value="{{ $project->fld_pid }}" selected>
                                            {{ $project->fld_name }}</option>@endif
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
                            {{-- <div class="col">
                                <select name="district_id" id="district_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">@lang('All Districts') </option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->fld_did }}" @selected(request('district_id') == $district->fld_did)>
                                            {{ $district->fld_district }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col">
                                <select name="user_id" id="user_id"
                                    class="form-control bg-light border-light flatpickr-input">
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
                                    @if (in_array(Auth::user()->fld_role, [1, 3]))
                                        <button type="submit" name="submit" value="export"
                                            class="col  mr-1 btn btn-success ">Export</button>
                                    @endif
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

                                        <!-- <th class="text-uppercase">ID</th> -->
                                        <th class="text-uppercase">Shop Name</th>
                                        <th class="text-uppercase">Owner Name</th>
                                        <th class="text-uppercase">Order Total</th>
                                        <th class="text-uppercase">Location</th>
                                        <th class="text-uppercase">State</th>
                                        <th class="text-uppercase">Sale Slip</th>
                                        <th class="text-uppercase">Shop Photo</th>
                                        <th class="text-uppercase">Field User</th>
                                        <th class="text-uppercase">Order Date</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="">
                                    @forelse ($records as $key=> $record)
                                        <tr>
                                            {{--<td>{{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                                            </td>--}}
                                            <td>{{ $record->shop_name }}
                                                <p class="text-muted mb-0">{{ $record->shop_type }}</p>
                                            </td>
                                            <td>{{ $record->owner_name }}
                                                <p class="text-muted mb-0">{{ $record->mobile_no }}</p>

                                            </td>
                                            <td>{{ $record->fld_total }}</td>
                                            <td>@include('components.locationTD')</td>
                                            <td>{{ $record->fld_state }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($record->fld_bill_photo_file)
                                                        <a class="image-popup"
                                                            href="{{ env('SERVER_BASE_URL') }}{{ $record->fld_bill_photo_path }}/{{ $record->fld_bill_photo_file }}"
                                                            title="{{ $record->fld_bill_photo_file }}">
                                                            <img class="gallery-img img-fluid mx-auto avatar-xs rounded me-2"
                                                                src="{{ env('SERVER_BASE_URL') }}{{ $record->fld_bill_photo_path }}/{{ $record->fld_bill_photo_file }}"
                                                                alt="{{ $record->fld_bill_photo_file }}">
                                                        </a>
                                                    @else
                                                        <i class="bx bx-image bx-md"></i>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($record->fld_photo_file)
                                                        <a class="image-popup"
                                                            href="{{ env('SERVER_BASE_URL') }}{{ $record->fld_photo_path }}/{{ $record->fld_photo_file }}"
                                                            title="{{ $record->fld_photo_file }}">
                                                            <img class="gallery-img img-fluid mx-auto avatar-xs rounded me-2"
                                                                src="{{ env('SERVER_BASE_URL') }}{{ $record->fld_photo_path }}/{{ $record->fld_photo_file }}"
                                                                alt="{{ $record->fld_photo_file }}">
                                                        </a>
                                                    @else
                                                        <i class="bx bx-image bx-md"></i>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $record->fld_name }}</td>
                                            <td> {{ date(env('DATE_FORMAT'), strtotime($record->fld_date)) }}</td>
                                            <td>
                                                <div class="d-flex gap-2">

                                                    <a class=""
                                                        href="{{ route('van.retailsales.details', $record->fld_rsid) }}">
                                                        <i class="ri-eye-line"></i></a>
                                                    @if (in_array(Auth::user()->fld_role, [1, 3]))
                                                        <form onsubmit="return confirm('Do you really want to delete?');"
                                                            action="{{ route('van.retailsales.delete', $record->fld_rsid) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-submit  ri-delete-bin-line">
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">
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
    <script src="{{ URL::asset('/build/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/build/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var request_state_id = "{{ request('state_id') }}"
            var request_district_id = "{{ request('district_id') }}"
            var request_user_id = "{{ request('user_id') }}"
            getLoads();
            async function getLoads() {
                await getState();

            }


            // Initialize form validation on the registration form.
            // It has the name attribute "registration"

            $("#project_id").change(function() {
                getState();
            });
            $("#state_id").change(function() {
                //getDistrict();
                getUsers();
            });

            async function getState() {
                let id = $('#project_id option:selected').val();
                if (id) {
                    (request_state_id) ?
                    $("#state_id").html('<option>loading....</option>'): '';
                    $.ajax({
                        url: `/get-project-wise-states/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All States </option>";
                            $.each(result, function(key, state) {
                                let selected = (state.fld_sid == request_state_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${state.fld_sid}' ${selected}> ${state.fld_state}</option>`
                            });

                            $("#state_id").html(html);

                        }
                    });
                }
            }

            function getUsers() {
                let id = $('#state_id option:selected').val();
                if (id) {
                    (request_user_id) ? $("#user_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/sales-report/retail-sale/get-state-wise-users/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Field Users </option>";
                            $.each(result, function(key, user) {
                                let selected = (user.fld_uid == request_user_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${user.fld_uid}' ${selected}> ${user.fld_name}</option>`
                            });

                            $("#user_id").html(html);

                        }
                    });


                }
            }

            // function getDistrict() {
            //     let id = $('#state_id option:selected').val();
            //     if (id) {
            //         (request_district_id) ? $("#district_id").html('<option>loading....</option>'): '';

            //         $.ajax({
            //             url: `/get-state-wise-district/${id}`,
            //             success: function(result) {
            //                 let html = "<option value='0'>All Districts </option>";
            //                 $.each(result, function(key, district) {
            //                     let selected = (district.fld_did == request_district_id) ?
            //                         'selected' : '';
            //                     html +=
            //                         `<option value='${district.fld_did}' ${selected}> ${district.fld_district}</option>`
            //                 });

            //                 $("#district_id").html(html);

            //             }
            //         });


            //     }
            // }

        });
    </script>
@endsection
