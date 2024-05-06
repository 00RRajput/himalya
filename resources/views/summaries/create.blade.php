        <form action="{{ route('summaries.store') }}" method="POST" name="add_new_record">
            @csrf
            <input type="hidden" value="{{ request('pid') }}" name="fld_pid" />
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New Summary</h4>
                </div>

                <div class="card-body">
                    <div class="live-preview">

                        <div class="row">

                            <!--end col-->

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fld_question" class="form-control-label">Question<sup>*</sup></label>

                                    <div class="@error('fld_question')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ old('fld_question') }}" type="text"
                                            placeholder="Enter Question" id="fld_question" name="fld_question" required>
                                        @error('fld_question')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fld_placeholder" class="form-control-label">Placeholder</label>

                                    <div class="@error('fld_placeholder')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ old('fld_placeholder') }}" type="text"
                                            placeholder="Enter Placeholder" id="fld_placeholder" name="fld_placeholder">
                                        @error('fld_placeholder')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fld_type" class="form-control-label">Type<sup>*</sup><span
                                            id="test"></span></label>
                                    <select class="form-control" name="fld_type" id="fld_type" required>
                                        <option value="">Select type</option>
                                        <option value="T">Text</option>
                                        <option value="R">Radio</option>
                                        <option value="S">Select</option>
                                        <option value="TA">Text Area</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-12" style="display: none" id="fld_isnumeric_div">
                                <div class="mb-3">
                                    <label for="fld_isnumeric" class="form-control-label">Is numeric</label>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="fld_isnumeric" type="checkbox"
                                            role="switch" id="flexSwitchCheckChecked" value=""
                                            name="fld_isnumeric" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12" style="display: none" id="radio_select_div">
                                <div class="mb-3">
                                    <label for="fld_ans" class="form-control-label">Ans<sup>*</sup></label>

                                    <div class="@error('fld_ans')border border-danger rounded-3 @enderror">
                                        <textarea class="form-control" type="text" placeholder="Enter Ans" id="fld_ans" name="fld_ans">{{ old('fld_ans') }}</textarea>
                                        @error('fld_ans')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label for="fld_required" class="form-control-label">Required</label>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="fld_required" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked="" value="1"
                                            name="fld_required" />
                                    </div>
                                </div>
                            </div>



                            <div class="col">
                                <div class="mb-3">
                                    <label for="fld_status" class="form-control-label">Status</label>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="fld_status" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked="" value="1"
                                            name="fld_status" />
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">

                                <div class="text-end">
                                    <a href="{{ route('projects.index') }}" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>

                        <!--end row-->
                    </div>
                </div>
            </div>

        </form>
