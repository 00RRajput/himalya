<form action="{{ route('phototypes.update', $phototype->fld_ptid) }}" method="POST" name="update_record">
    @method('PUT')
    @csrf

    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Edit {{ $phototype->fld_purpose }}</h4>
        </div>

        <div class="card-body">
            <div class="live-preview">

                <div class="row">

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="fld_purpose" class="form-control-label">Purpose<sup>*</sup></label>

                            <div class="@error('fld_purpose')border border-danger rounded-3 @enderror">
                                <input class="form-control" value="{{ old('fld_purpose', $phototype->fld_purpose) }}"
                                    type="text" placeholder="Enter purpose name" id="fld_purpose" name="fld_purpose"
                                    required>
                                @error('fld_purpose')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="fld_type" class="form-control-label">Photo Type<sup>*</sup></label>

                            <div class="@error('fld_type')border border-danger rounded-3 @enderror">
                                <input class="form-control" value="{{ old('fld_type', $phototype->fld_type) }}"
                                    type="text" placeholder="Enter photo type  name" id="fld_type" name="fld_type"
                                    required>
                                @error('fld_type')
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
                                    id="flexSwitchCheckChecked" @checked($phototype->fld_status == 1) value="1"
                                    name="status" />
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-12">

                        <div class="text-end">
                            <a href="{{ route('phototypes.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>

                <!--end row-->
            </div>
        </div>
    </div>
</form>
