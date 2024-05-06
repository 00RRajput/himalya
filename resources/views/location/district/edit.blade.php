<form action="{{ route('district.update', $district->fld_did) }}" method="POST" name="update_record">
    @method('PUT')
    @csrf

    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Edit {{ $district->fld_district }}</h4>
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
                                    <option value="{{ $state->fld_sid }}" @selected($district->fld_state_id == $state->fld_sid)>
                                        {{ $state->fld_state }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="fld_district" class="form-control-label">District<sup>*</sup></label>

                            <div class="@error('fld_district')border border-danger rounded-3 @enderror">
                                <input class="form-control" value="{{ old('fld_district', $district->fld_district) }}"
                                    type="text" placeholder="Enter name" id="fld_district" name="fld_district"
                                    required>
                                @error('fld_district')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fld_status" class="form-control-label">Status</label>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="fld_status"
                                    @checked($record->fld_status == 1) value="1" name="fld_status">
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-12">

                        <div class="text-end">
                            <a href="{{ route('district.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>

                <!--end row-->
            </div>
        </div>
    </div>

</form>
