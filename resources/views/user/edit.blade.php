<form action="{{ route('users.update', $user->fld_uid) }}" method="POST" name="add_newuser">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Edit {{ $user->username }}</h4>
        </div>

        <div class="card-body">
            <div class="live-preview">

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="fld_username" class="form-control-label">Username<sup>*</sup></label>
                            <div class="@error('fld_username')border border-danger rounded-3 @enderror">
                                <input class="form-control" value="{{ old('fld_username', $user->fld_username) }}"
                                    type="text" placeholder="Enter user name" id="fld_username" name="fld_username"
                                    required>
                                @error('fld_username')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <!--end col-->


                    <div class="col-12">
                        <div class="mb-3">
                            <label for="fld_state_id" class="form-control-label">State<sup>*</sup></label>
                            <div class="@error('fld_state_id')border border-danger rounded-3 @enderror">
                                <select class="form-control" id="fld_state_id" name="fld_state_id" required>
                                    <option value="">Select state</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->fld_sid }}" data-state="{{ $state->fld_sid }}"
                                            @selected($state->fld_sid === $user->fld_state_id)>
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

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="fld_project_id" class="form-control-label">Projects<sup>*</sup></label>
                            <div class="@error('fld_project_id')border border-danger rounded-3 @enderror">
                                <select class="form-control" id="fld_project_id" name="fld_project_id" required>
                                    <option value="">Select project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->fld_pid }}" @selected($project->fld_pid === $user->fld_project_id)>
                                            {{ $project->fld_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fld_project_id')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="fld_role" class="form-control-label">Roles<sup>*</sup></label>
                            <div class="@error('fld_role')border border-danger rounded-3 @enderror">
                                <select class="form-control" id="fld_role" name="fld_role" required>
                                    <option value="">Select user role</option>
                                    <option value="1" @selected(1 == $user->fld_role)>Admin</option>
                                    <option value="2" @selected(2 == $user->fld_role)>Field User</option>
                                    <option value="3" @selected(3 == $user->fld_role)>Nebula</option>
                                    <option value="4" @selected(4 == $user->fld_role)>Client</option>
                                    <option value="4" @selected(5 == $user->fld_role)>Vendor </option>
                                </select>
                                @error('fld_role')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check form-switch form-check-right mb-2">
                            <label class="form-check-label" for="flexSwitchCheckRightDisabled">Status</label>
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="flexSwitchCheckRightDisabled" name="fld_status" @checked($user->fld_status == 1)>

                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-12">

                        <div class="text-end">
                            <a href="{{ route('users.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>

                <!--end row-->
            </div>
        </div>
    </div>

</form>
