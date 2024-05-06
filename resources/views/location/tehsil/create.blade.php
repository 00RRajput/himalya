        <form action="{{ route('tehsil.store') }}" method="POST" name="add_new_record">
            @csrf

            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New Tehsil</h4>
                </div>

                <div class="card-body">
                    <div class="live-preview">

                        <div class="row">

                            <!--end col-->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_state_id" class="form-control-label">State<sup>*</sup></label>

                                    <select id="fld_state_id" name="fld_state_id"
                                        class="form-control bg-light border-light flatpickr-input">
                                        <option value="">All States</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->fld_sid }}" @selected(old('fld_state_id') == $state->fld_sid)>
                                                {{ $state->fld_state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_district_id"
                                        class="form-control-label">Districts<sup>*</sup></label>

                                    <select id="fld_district_id" name="fld_district_id"
                                        class="form-control bg-light border-light flatpickr-input">
                                        <option value="">All Districts</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_tehsil" class="form-control-label">Tehsil<sup>*</sup></label>

                                    <div class="@error('fld_tehsil')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ old('fld_tehsil') }}" type="text"
                                            placeholder="Enter  name" id="fld_tehsil" name="fld_tehsil" required>
                                        @error('fld_district')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_name" class="form-control-label">Status</label>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" value="1" name="fld_status" />
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">

                                <div class="text-end">
                                    <a href="{{ route('clients.index') }}" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>

                        <!--end row-->
                    </div>
                </div>
            </div>

        </form>
