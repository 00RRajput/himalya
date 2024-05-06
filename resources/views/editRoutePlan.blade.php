@extends('layouts.master')
@section('title')
    @lang('Edit Route Plan')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang('Edit Route Plan')
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
                <form action="{{ route('master.update.routePlans', $routePlan->fld_rpid) }}" method="POST" name="add_new">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="live-preview">

                            <div class="row">
                                <!--end col-->
                                <div class="col-4 mb-3">
                                    <label for="state_id" class="form-control-label">State<sup>*</sup></label>

                                    <select id="state_id" name="state_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">All States</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->fld_sid }}" @selected($routePlan->fld_state_id == $state->fld_sid)>
                                                {{ $state->fld_state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="district_id" class="form-control-label">District<sup>*</sup></label>
                                    <select name="district_id" id="district_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">@lang('All Districts') </option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->fld_did }}" @selected($routePlan->fld_district_id == $district->fld_did)>
                                                {{ $district->fld_district }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="village_id" class="form-control-label">Village<sup>*</sup></label>
                                    <select name="village_id" id="village_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">@lang('All Villages') </option>
                                        @foreach ($villages as $village)
                                            <option value="{{ $village->fld_vid }}" @selected($routePlan->fld_village_id == $village->fld_vid)>
                                                {{ $village->fld_village }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="user_id" class="form-control-label">User<sup>*</sup></label>
                                    <select name="user_id" id="user_id"
                                        class="form-control bg-light border-light flatpickr-input" required>
                                        <option value="">@lang('All Field Users') </option>
                                        @foreach ($users as $user)
                                            <option data-username="{{ $user->fld_username }}" value="{{ $user->fld_uid }}"
                                                @selected($routePlan->fld_uid == $user->fld_uid)>
                                                {{ $user->fld_username }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="fld_date" class="form-control-label">Date<sup>*</sup></label>

                                        <div class="@error('fld_date')border border-danger rounded-3 @enderror">
                                            <input class="form-control" value="{{ old('fld_date', $routePlan->fld_date) }}"
                                                type="date" placeholder="Enter user name" id="fld_date" name="fld_date"
                                                required>
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
                                    <a href="{{ route('report.routePlan') }}" class="btn btn-light">Cancel</a>
                                    <input class="form-control" type="hidden" readonly id="fld_tid"
                                        value="{{ $routePlan->fld_tehsil_id }}" name="fld_tid" required>
                                    <input class="form-control" type="hidden" readonly id="fld_uid"
                                        value="{{ $routePlan->fld_uid }}" name="fld_uid" required>
                                    <input class="form-control" type="hidden" readonly id="fld_username"
                                        value="{{ $routePlan->fld_user }}" name="fld_username" required>

                                    <button type="submit" class="btn btn-primary">Update</button>
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
