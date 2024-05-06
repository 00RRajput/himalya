@extends('layouts.master')
@section('title')
    @lang('Add New User')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('Master')
        @endslot
        @slot('title')
            @lang('Add New User')
        @endslot
    @endcomponent
    @if (session('success'))
        <div class="m-3  alert bg-success alert-dismissible  show" id="alert-success" role="alert">
            <span class="alert-text text-white">
                {!! session('success') !!}</span>
        </div>
    @endif

    <div class="row">
        <div class="col-xxl-6">
            <form action="{{ route('users.store') }}" method="POST" name="add_newuser">
                @csrf

                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"></h4>
                    </div>

                    <div class="card-body">
                        <div class="live-preview">

                            <div class="row">

                                <!--end col-->
                                {{-- <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="employee_code" class="form-control-label">Name<sup>*</sup></label>

                                        <div class="@error('fld_name')border border-danger rounded-3 @enderror">
                                            <input class="form-control" value="{{ old('fld_name') }}" type="text"
                                                placeholder="Enter  name" id="fld_name" name="fld_name" required>
                                            @error('fld_name')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}
                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fld_username" class="form-control-label">Username<sup>*</sup></label>
                                        <div class="@error('fld_username')border border-danger rounded-3 @enderror">
                                            <input class="form-control" value="{{ old('fld_username') }}" type="text"
                                                placeholder="Enter user name" id="fld_username" name="fld_username"
                                                required>
                                            @error('fld_username')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fld_password" class="form-control-label">Password<sup>*</sup></label>
                                        <div class="@error('fld_password')border border-danger rounded-3 @enderror">
                                            <input class="form-control" value="{{ old('fld_password', 12345678) }}"
                                                type="password" placeholder="Enter password" id="fld_password"
                                                name="fld_password" required>
                                            @error('fld_password')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->


                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="fld_state_id" class="form-control-label">State<sup>*</sup></label>
                                        <div class="@error('fld_state_id')border border-danger rounded-3 @enderror">
                                            <select class="form-control" id="fld_state_id" name="fld_state_id" required>
                                                <option value="">Select state</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->fld_sid }}"
                                                        data-state="{{ $state->fld_sid }}">
                                                        {{ $state->fld_state }}</option>
                                                @endforeach
                                            </select>
                                            @error('fld_state_id')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="fld_project_id" class="form-control-label">Projects<sup>*</sup></label>
                                        <div class="@error('fld_project_id')border border-danger rounded-3 @enderror">
                                            <select class="form-control" id="fld_project_id" name="fld_project_id" required>
                                                <option>Select project</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->fld_pid }}">{{ $project->fld_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('fld_project_id')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="fld_role" class="form-control-label">Roles<sup>*</sup></label>
                                        <div class="@error('fld_role')border border-danger rounded-3 @enderror">
                                            <select class="form-control" id="fld_role" name="fld_role" required>
                                                <option>Select user role</option>
                                                <option value="1">Admin</option>
                                                <option value="2">Field User</option>
                                                <option value="3">Nebula</option>
                                                <option value="4">Client</option>
                                                <option value="5">Vendor</option>
                                            </select>
                                            @error('fld_role')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check form-switch form-check-right mb-2">
                                        <br />
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckRightDisabled" name="fld_status">
                                        <label class="form-check-label" for="flexSwitchCheckRightDisabled">Status</label>

                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">

                                    <div class="text-end">
                                        <a href="{{ route('users.index') }}" class="btn btn-light">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>

                            <!--end row-->
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/build/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/build/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script type="text/javascript">
        $(function() {
            // Initialize form validation on the registration form.
            // It has the name attribute "registration"
            $("form[name='add_newuser']").validate({
                // Specify validation rules
                rules: {
                    fld_name: "required",
                    fld_username: "required",
                    fld_state_id: "required",
                    fld_district_id: "required",
                    fld_project_id: "required",
                    fld_role: "required",
                },
                // Specify validation error messages

                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
    <script>
    @endsection
