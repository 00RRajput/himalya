@extends('layouts.master')
@section('title')
    @lang('Add New Route Plan')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang('Add New Route Plan')
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
                <form action="{{ route('mandi.store.routePlans') }}" method="POST" name="add_new">
                    @csrf
                    <div class="card-body">
                        <div class="live-preview">

                            <div class="row">
                                <div class="col-4 mb-3">
                                    <select id="fld_project_id" name="fld_project_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">All Projects</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->fld_pid }}" @selected(session('project_id') == $project->fld_pid || request('project_id') == $project->fld_pid)>
                                                {{ $project->fld_name }}</option>
                                        @endforeach
                                        @error('fld_project_id')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                    </select>
                                </div>
                                <!--end col-->
                                <div class="col-4 mb-3">
                                    <select id="state_id" name="state_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">All States</option>
                                        @foreach ($states as $state)
                                                    <option value="{{ $state->fld_sid }}" @selected(request('state_id') == $state->fld_sid)>
                                                        {{ $state->fld_state }}</option>
                                                @endforeach 
                                                @error('state_id')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select name="district_id" id="district_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">@lang('All Districts') </option>
                                        @foreach ($destrict as $d)
                                                    <option value="{{ $d->fld_did }}" @selected(request('state_id') == $d->fld_did)>
                                                        {{ $d->fld_district }}</option>
                                                @endforeach 
                                                @error('district_id')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select id="fld_tid" name="fld_tid"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">All Towns</option>
                                        @foreach ($towns as $town)
                                                    <option value="{{ $town->fld_tid }}" @selected(request('state_id') == $town->fld_tid)>
                                                        {{ $town->fld_town }}</option>
                                                @endforeach 
                                                @error('fld_tid')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select id="mandi_id" name="mandi_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">All Mandis</option>
                                        @foreach ($mandis as $mandi)
                                                    <option value="{{ $mandi->fld_mid }}" @selected(request('state_id') == $mandi->fld_mid)>
                                                        {{ $mandi->fld_mandi }}</option>
                                                @endforeach 
                                                @error('mandi_id')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <select name="wholesaler_id" id="wholesaler_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">@lang('All Wholesalers') </option>
                                        @foreach ($wholesalers as $w)
                                                    <option value="{{ $w->fld_wsid }}" @selected(request('state_id') == $w->fld_wsid)>
                                                        {{ $w->fld_wholesaler }}</option>
                                                @endforeach 
                                                @error('wholesaler_id')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                    </select>
                                </div>

                                <div class="col-4">
                                    <select name="user_id" id="user_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">@lang('All Field Users') </option>
                                        @foreach ($users as $u)
                                                    <option value="{{ $u->fld_uid }}" @selected(request('state_id') == $u->fld_uid)>
                                                        {{ $u->fld_name }}</option>
                                                @endforeach 
                                                @error('user_id')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                    </select>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <div class="@error('fld_date')border border-danger rounded-3 @enderror">
                                            <input class="form-control" value="{{ old('fld_date') }}" type="date"
                                                placeholder="Enter user name" id="fld_date" name="fld_date" required>
                                            @error('fld_date')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end col-->
                            <div class="col-lg-12">

                                <div class="text-end">
                                    <!-- <a href="{{ route('report.routePlan') }}" class="btn btn-light">Cancel</a>
                                    <input class="form-control" type="hidden" readonly id="fld_tid" name="fld_tid"
                                        required>
                                    <input class="form-control" type="hidden" readonly id="fld_uid" name="fld_uid"
                                        required>
                                    <input class="form-control" type="hidden" readonly id="fld_username"
                                        name="fld_username" required> -->

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>

                        <!--end row-->
                    </div>
                </form>
            </div>
        </div>
    </div>
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
            $("#fld_project_id").change(function() {
                getState();
                getUsers();
            });
            $("#state_id").change(function() {
                getDistrict();
            });
            $("#district_id").change(function() {
                getVillage();
            });
            $("#village_id").change(function() {
                let tname = $('#village_id option:selected').attr('data-tehsil-name');
                let tid = $('#village_id option:selected').attr('data-tehsil-id');
                $("#fld_tid").val(tid);
            });

            $("#user_id").change(function() {
                let username = $('#user_id option:selected').attr('data-username');
                let uid = $('#user_id option:selected').val();
                $("#fld_username").val(username);
                $("#fld_uid").val(uid);
            });

            async function getState() {
                let id = $('#fld_project_id option:selected').val();
                if (id) {
                    (request_state_id) ?
                    $("#state_id").html('<option>loading....</option>'): '';
                    $.ajax({
                        url: `/getState/${id}`,
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
                let id = $('#fld_project_id option:selected').val();
                if (id) {
                    (request_user_id) ? $("#user_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/getUsers/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Field Users </option>";
                            $.each(result, function(key, user) {
                                let selected = (user.fld_uid == request_user_id) ?
                                    'selected' : '';
                                html +=
                                    `<option data-username='${user.fld_username}' value='${user.fld_uid}' ${selected}> ${user.fld_username}</option>`
                            });

                            $("#user_id").html(html);

                        }
                    });


                }
            }

            function getDistrict() {
                let id = $('#state_id option:selected').val();
                if (id) {
                    (request_district_id) ? $("#district_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/getDistrict/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Districts </option>";
                            $.each(result, function(key, district) {
                                html +=
                                    `<option value='${district.fld_did}'> ${district.fld_district}</option>`
                            });

                            $("#district_id").html(html);

                        }
                    });


                }
            }

            function getVillage() {
                let id = $('#district_id option:selected').val();
                if (id) {
                    (request_district_id) ? $("#village_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/geVillages/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Villages </option>";
                            $.each(result, function(key, village) {
                                html +=
                                    `<option value='${village.fld_vid}' data-tehsil-name='${village.fld_tehsil}' data-tehsil-id='${village.fld_tehsil_id}'   > ${village.fld_village}</option>`
                            });

                            $("#village_id").html(html);

                        }
                    });


                }
            }

        });
    </script>
@endsection
