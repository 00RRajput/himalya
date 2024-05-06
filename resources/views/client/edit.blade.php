<form action="{{ route('clients.update', $client->fld_cid) }}" method="POST" name="update_new_client">
    @method('PUT')
    @csrf

    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Edit {{ $client->fld_name }}</h4>
        </div>

        <div class="card-body">
            <div class="live-preview">

                <div class="row">

                    <!--end col-->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fld_name" class="form-control-label">Client Name<sup>*</sup></label>

                            <div class="@error('fld_name')border border-danger rounded-3 @enderror">
                                <input class="form-control" value="{{ old('fld_name', $client->fld_name) }}"
                                    type="text" placeholder="Enter  name" id="fld_name" name="fld_name" required>
                                @error('fld_name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fld_name" class="form-control-label">Status</label>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="flexSwitchCheckChecked" @checked($client->fld_name === 1) value="1"
                                    name="status">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Checked to
                                    active</label>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-12">

                        <div class="text-end">
                            <a href="{{ route('clients.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>

                <!--end row-->
            </div>
        </div>
    </div>

</form>
