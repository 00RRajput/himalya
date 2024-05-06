@extends('layouts.master')
@section('title')
    @lang('Consumers')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang('Consumers')
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
                    <form action="{{ url('master/consumer') }}" method="GET">
                        <div class="row g-3">
                            <!--end col-->
                            <div class="col">
                                <select name="project_id" id="project_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <!-- <option value="">Select Project </option> -->
                                    @foreach ($projects as $project)
                                        @if($project->fld_pid == 1)<option value="{{ $project->fld_pid }}" @selected(session('project_id') == $project->fld_pid || request('project_id') == $project->fld_pid)>
                                            {{ $project->fld_name }}</option> @endif
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
                                <select name="user_id" id="user_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">@lang('All Field Users') </option>
                                    {{-- @foreach ($users as $user)
                                        <option value="{{ $user->fld_uid }}" @selected(request('user_id') == $user->fld_uid)>
                                            {{ $user->fld_name }}</option>
                                    @endforeach --}}
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
                                    <button type="submit" name="submit" value="add"
                                        class="col  mr-1 btn btn-primary">Search</button>
                                    <a class="btn btn-secondary col ml-1" href="{{ url('master/consumer') }}">Reset</a>
                                    @if (in_array(Auth::user()->fld_role, [1, 3]))
                                        <button type="submit" name="submit" value="export"
                                            class="col  mr-1 btn btn-success">Export</button>
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
                                        <th class="text-uppercase">Consumer</th>
                                        <th class="text-uppercase">Mobile</th>
                                        <th class="text-uppercase">Location</th>
                                        <th class="text-uppercase">State</th>
                                        <th class="text-uppercase">Total</th>
                                        <th class="text-uppercase">Project</th>
                                        <th class="text-uppercase">Field User</th>
                                        <th class="text-uppercase">Date</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="">
                                    @forelse ($records as $key=> $record)
                                        <tr>
                                            {{--<td>{{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                                            </td>--}}
                                            <td class="td">{{ $record->consumer_name }}</td>
                                            <td class="td">{{ $record->fld_number }}</td>
                                            <td>{{ $record->village_name }}
                                                <p class="text-muted mb-0"> <a
                                                        href="http://maps.google.com/?q={{ $record->fld_lat }},{{ $record->fld_long }}"
                                                        target="_blank" class="ri-map-pin-fill"></a>
                                                    {{ $record->district_name }}</p>
                                            </td>
                                            <td class="td">{{ $record->state_name }}</td>
                                            <td>
                                                {{ $record->fld_total ?? 0 }}
                                            </td>
                                            <td class="td">{{ $record->project_name }}</td>
                                            <td class="td">{{ $record->fld_name }}</td>
                                            <td>
                                                {{ date(env('DATE_FORMAT'), strtotime($record->fld_created_at)) }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @if ($record->fld_total)
                                                        <a class=""
                                                            href="{{ route('van.consumersales', ['cid' => $record->fld_cid]) }}">
                                                            <i class="ri-eye-line"></i></a>
                                                    @endif
                                                    <a href="{{ route('salesreport.consumersales.addnew', ['cid' => $record->fld_cid]) }}"
                                                        data-id="25000351"><i class="ri-add-box-fill text-muted"></i>
                                                    </a>
                                                    @if (in_array(Auth::user()->fld_role, [1, 3]))
                                                        <form
                                                            onsubmit="return confirm('Do you really want to delete? All the consumer sale and items record will be deleted ?');"
                                                            action="{{ route('consumer.destroy', $record->fld_cid) }}"
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
            var request_uid = "{{ request('user_id') }}"
            getLoads();
            async function getLoads() {
                await getState();
                await getUsers();

            }


            // Initialize form validation on the registration form.
            // It has the name attribute "registration"

            $("#project_id").change(function() {
                getState();
                getUsers();
            });
            // $("#state_id").change(function() {
            //     getDistrict();
            // });

            async function getState() {
                let id = $('#project_id option:selected').val();
                if (id > 0) {
                    (request_state_id > 0) ?
                    $("#state_id").html('<option>loading....</option>'): '';
                    $.ajax({
                        url: `/consumers/get-project-wise-states/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All States </option>";
                            $.each(result, function(key, state) {
                                let selected = (state.fld_sid == request_state_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${state.fld_sid}' ${selected}> ${state.fld_state}</option>`
                            });

                            $("#state_id").html(html);
                            getDistrict();
                        }
                    });
                }
            }


            function getDistrict() {
                let id = $('#state_id option:selected').val();
                if (id > 0) {
                    (request_district_id > 0) ? $("#district_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/consumers/get-state-wise-district/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Districts </option>";
                            $.each(result, function(key, district) {
                                let selected = (district.fld_did == request_district_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${district.fld_did}' ${selected}> ${district.fld_district}</option>`
                            });

                            $("#district_id").html(html);

                        }
                    });


                }
            }

            function getUsers() {
                let id = $('#project_id option:selected').val();
                if (id > 0) {
                    (request_district_id > 0) ? $("#user_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/consumers/get-project-wise-users/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Field Users </option>";
                            $.each(result, function(key, user) {
                                let selected = (user.fld_uid == request_uid) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${user.fld_uid}' ${selected}> ${user.fld_name}</option>`
                            });

                            $("#user_id").html(html);

                        }
                    });


                }
            }


        });

        function ViewInvoice(order) {
            console.log(order);
        }
    </script>
@endsection
