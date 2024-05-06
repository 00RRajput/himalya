<form action="{{ route('village.update', $village->fld_vid) }}" method="POST" name="update_record">
    @method('PUT')
    @csrf

    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Edit {{ $village->fld_village }}</h4>
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
                                    <option value="{{ $state->fld_sid }}" @selected($village->fld_state_id == $state->fld_sid)>
                                        {{ $state->fld_state }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="fld_district_id" class="form-control-label">Districts<sup>*</sup></label>

                            <select id="fld_district_id" name="fld_district_id"
                                class="form-control bg-light border-light flatpickr-input">
                                <option value="">All Districts</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->fld_did }}" @selected($village->fld_district_id == $district->fld_did)>
                                        {{ $district->fld_district }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="fld_tehsil_id" class="form-control-label">Tehsil<sup>*</sup></label>

                            <select id="fld_tehsil_id" name="fld_tehsil_id"
                                class="form-control bg-light border-light flatpickr-input">
                                <option value="">All Tehsil</option>
                                @foreach ($tehsils as $tehsil)
                                    <option value="{{ $tehsil->fld_tid }}" @selected($village->fld_tehsil_id == $tehsil->fld_tid)>
                                        {{ $tehsil->fld_tehsil }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="fld_village" class="form-control-label">Village<sup>*</sup></label>

                            <div class="@error('fld_village')border border-danger rounded-3 @enderror">
                                <input class="form-control" value="{{ old('fld_village', $village->fld_village) }}"
                                    type="text" placeholder="Enter name" id="fld_village" name="fld_village"
                                    required>
                                @error('fld_village')
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
                            <a href="{{ route('village.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>

                <!--end row-->
            </div>
        </div>
    </div>

</form>




@section('script')
    <script src="{{ URL::asset('/build/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/build/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var request_state_id = "{{ request('state_id') }}"
            var request_district_id = "{{ request('district_id') }}"
            // getLoads();
            async function getLoads() {
                await getDistrict();
            }

            $("#fld_state_id").change(function() {
                getDistrict();
            });


            function getDistrict() {
                let id = $('#fld_state_id option:selected').val();
                if (id > 0) {
                    $.ajax({
                        url: `/getDistrict/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Districts </option>";
                            $.each(result, function(key, district) {
                                let selected = (district.fld_did == request_district_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${district.fld_did}'> ${district.fld_district}</option>`
                            });

                            $("#fld_district_id").html(html);

                        }
                    });


                }
            }
        });

        function ViewInvoice(order) {
            console.log(order);
        }
    </script>
@endsection
