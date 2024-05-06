        <form action="{{ route('phototypes.store') }}" method="POST" name="add_new_record">
            @csrf

            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New Photo Type</h4>
                </div>

                <div class="card-body">
                    <div class="live-preview">

                        <div class="row">

                            <!--end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_type" class="form-control-label">Photo Type<sup>*</sup></label>

                                    <div class="@error('fld_type')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ old('fld_type') }}" type="text"
                                            placeholder="Enter photo type  name" id="fld_type" name="fld_type"
                                            required>
                                        @error('fld_type')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fld_purpose" class="form-control-label">Purpose<sup>*</sup></label>

                                    <div class="@error('fld_purpose')border border-danger rounded-3 @enderror">

                                        <select id="fld_purpose"
                                            class="form-control @error('fld_purpose')border border-danger rounded-3 @enderror"
                                            name="fld_purpose" id="fld_purpose" required>
                                            <option value="">Select Purpose</option>
                                            @foreach ($purposes as $purpose)
                                                <option value="{{ $purpose->fld_purpose }}">{{ $purpose->fld_purpose }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('fld_purpose')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="status" class="form-control-label">Status</label>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked="" value="1" name="status" />
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">

                                <div class="text-end">
                                    <a href="{{ route('phototypes.index') }}" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>

                        <!--end row-->
                    </div>
                </div>
            </div>

        </form>
