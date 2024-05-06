    <form action="{{ route('summaries.update', $summary->fld_scfid) }}" method="POST" name="add_new_record">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ request('pid') }}" name="fld_pid" />
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Edit {{ $summary->fld_question }}</h4>
            </div>

            <div class="card-body">
                <div class="live-preview">

                    <div class="row">

                        <!--end col-->

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="fld_question" class="form-control-label">Question<sup>*</sup></label>

                                <div class="@error('fld_question')border border-danger rounded-3 @enderror">
                                    <input class="form-control"
                                        value="{{ old('fld_question', $summary->fld_question) }}" type="text"
                                        placeholder="Enter Question" id="fld_question" name="fld_question" required>
                                    @error('fld_question')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="fld_placeholder" class="form-control-label">Placeholder<sup>*</sup></label>

                                <div class="@error('fld_placeholder')border border-danger rounded-3 @enderror">
                                    <input class="form-control"
                                        value="{{ old('fld_placeholder', $summary->fld_placeholder) }}" type="text"
                                        placeholder="Enter Placeholder" id="fld_placeholder" name="fld_placeholder"
                                        required>
                                    @error('fld_placeholder')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="fld_type" class="form-control-label">Type</label>
                                <select class="form-control" name="fld_type" id="fld_type">
                                    <option @selected($summary->fld_type == '0') value="">Select type</option>
                                    <option @selected($summary->fld_type == 'T') value="T">Text</option>
                                    <option @selected($summary->fld_type == 'R') value="R">Radio</option>
                                    <option @selected($summary->fld_type == 'S') value="S">Select</option>
                                    <option @selected($summary->fld_type == 'TA') value="TA">Text Area</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-12 @if ($summary->fld_type == 'T' || $summary->fld_type == 'TA') @else display-none @endif"
                            id="fld_isnumeric_div">
                            <div class="mb-3">
                                <label for="fld_isnumeric" class="form-control-label">Is numeric</label>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="fld_isnumeric" type="checkbox" role="switch"
                                        id="flexSwitchCheckChecked" @checked($summary->fld_isnumeric) name="fld_isnumeric" />
                                </div>
                            </div>
                        </div>

                        <div class="col-12 @if ($summary->fld_type == 'R' || $summary->fld_type == 'S') @else display-none @endif"
                            id="radio_select_div">
                            <div class="mb-3">
                                <label for="fld_ans" class="form-control-label">Ans<sup>*</sup></label>

                                <div class="@error('fld_ans')border border-danger rounded-3 @enderror">
                                    <textarea class="form-control" placeholder="Enter Ans" id="fld_ans" name="fld_ans">{{ old('fld_ans', $summary->fld_ans) }}</textarea>
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
                                        id="flexSwitchCheckChecked" @checked($summary->fld_required == 1) value="1"
                                        name="fld_required" />
                                </div>
                            </div>
                        </div>



                        <div class="col">
                            <div class="mb-3">
                                <label for="fld_status" class="form-control-label">Status</label>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="fld_status" type="checkbox" role="switch"
                                        id="flexSwitchCheckChecked" @checked($summary->fld_status == 1) value="1"
                                        name="fld_status" />
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">

                            <div class="text-end">
                                <a href="{{ route('summaries.index', ['pid' => request('pid')]) }}"
                                    class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>

                    <!--end row-->
                </div>
            </div>
        </div>

    </form>
