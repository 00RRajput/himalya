<div class="row">
    <div class="col-lg-8">
        <div class="card" id="invoiceList">
            @if (session('success'))
                <div class="m-3  alert bg-success alert-dismissible  show" id="alert-success" role="alert">
                    <span class="alert-text text-white">
                        {{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                    </button>
                </div>
            @endif
            <div class="card-body bg-soft-light border border-dashed border-start-0 border-end-0">
                <form action="{{ url('/location/village') }}" method="GET">
                    <div class="row g-3">
                        <!--end col-->
                        <div class="col">
                            <select id="state_id" name="state_id"
                                class="form-control bg-light border-light flatpickr-input">
                                <option value="">All States</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->fld_sid }}" @selected(request('state_id') == $state->fld_sid)>
                                        {{ $state->fld_state }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select id="district_id" name="district_id"
                                class="form-control bg-light border-light flatpickr-input">
                                <option value="">All Districts</option>
                            </select>
                        </div>
                        <div class="col">
                            <select id="tehsil_id" name="tehsil_id"
                                class="form-control bg-light border-light flatpickr-input">
                                <option value="">All Tehsils</option>
                            </select>
                        </div>

                        <div class="col">
                            <div class="d-flex gap-2">
                                <button type="submit" class="col  mr-1 btn btn-primary">Search</button>
                                <button type="submit" name="submit" value="reset"
                                    class="col  mr-1 btn btn-secondary ">Reset</button>

                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-nowrap" id="">
                            <thead class="text-muted">
                                <tr>

                                    <th class="text-uppercase">#</th>
                                    <th class="text-uppercase">State</th>
                                    <th class="text-uppercase">District</th>
                                    <th class="text-uppercase">Tehsil</th>
                                    <th class="text-uppercase">Village</th>
                                    <th class="text-uppercase">Status</th>
                                    <th class="text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all" id="">
                                @forelse ($records as $key => $record)
                                    <tr>
                                        <td>
                                            {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="td"> {{ $record->state->fld_state }}</td>
                                        <td class="td">{{ $record->district->fld_district }}</td>
                                        <td class="td">{{ $record->tehsil->fld_tehsil }}</td>
                                        <td class="td">{{ $record->fld_village }}</td>
                                        <td class="td {{ $record->fld_status ? 'text-green' : 'bg-red' }}">
                                            {{ $record->fld_status ? 'Active' : 'Deactive' }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a class="ri-edit-line"
                                                    href="{{ route('village.edit', $record->fld_vid) }}"></a>

                                                <form action="{{ route('village.destroy', $record->fld_vid) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn-submit ri-delete-bin-line"></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="noresult">
                                                <div class="text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                        trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                                        style="width:75px;height:75px">
                                                    </lord-icon>
                                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <div class="pagination-wrap hstack gap-2" style="display: flex;">
                            {{ $records->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="col-lg-4">
        @if (request()->route()->getName() === 'village.edit')
            @include('location.village.edit', [
                'districts' => $districts,
                'states' => $states,
                'village' => $village,
                'tehsils' => $tehsils,
                'records' => $records,
            ])
        @else
            @include('location.village.create')
        @endif

    </div>
</div>


@section('script')
    <script src="{{ URL::asset('/build/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/build/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var request_state_id = "{{ request('state_id') }}"
            var request_district_id = "{{ request('district_id') }}"
            var request_tehsil_id = "{{ request('tehsil_id') }}"
            getLoads();

            async function getLoads() {
                await getDistrict();
                await getTehsil();
            }

            $("#state_id").change(function() {

                getDistrict();
            });
            $("#district_id").change(function() {

                getTehsil();
            });


            function getDistrict() {
                let id = $('#state_id option:selected').val();
                if (id > 0) {
                    $.ajax({
                        url: `/getDistrict/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Districts </option>";
                            $.each(result, function(key, district) {
                                let selected = (district.fld_did == request_district_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${district.fld_did}' ${selected}> ${district.fld_district}</option>`
                            });

                            $("#district_id").html(html);
                            getTehsil();

                        }
                    });


                }
            }

            function getTehsil() {
                let id = $('#district_id option:selected').val();
                if (id > 0) {
                    $.ajax({
                        url: `/getTehsil/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Tehsils </option>";
                            $.each(result, function(key, district) {
                                let selected = (district.fld_tid == request_tehsil_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${district.fld_tid}' ${selected}> ${district.fld_tehsil}</option>`
                            });

                            $("#tehsil_id").html(html);

                        }
                    });


                }
            }

            $(document).ready(function() {
                var request_state_id = "{{ request('state_id') }}"
                var request_district_id = "{{ request('district_id') }}"
                getLoads();
                async function getLoads() {
                    await getDistrict();
                }

                $("#fld_state_id").change(function() {
                    getDistrict();
                });

                $("#fld_district_id").change(function() {
                    getTehsil();
                });


                function getDistrict() {
                    let id = $('#fld_state_id option:selected').val();
                    if (id > 0) {
                        $.ajax({
                            url: `/getDistrict/${id}`,
                            success: function(result) {
                                let html = "<option value='0'>All Districts </option>";
                                $.each(result, function(key, district) {
                                    let selected = (district.fld_did ==
                                            request_district_id) ?
                                        'selected' : '';
                                    html +=
                                        `<option value='${district.fld_did}' ${selected}> ${district.fld_district}</option>`
                                });

                                $("#fld_district_id").html(html);

                            }
                        });


                    }
                }

                function getTehsil() {
                    let id = $('#fld_district_id option:selected').val();
                    if (id > 0) {
                        $.ajax({
                            url: `/getTehsil/${id}`,
                            success: function(result) {
                                let html = "<option value='0'>All Districts </option>";
                                $.each(result, function(key, district) {

                                    html +=
                                        `<option value='${district.fld_tid}'> ${district.fld_tehsil}</option>`
                                });

                                $("#fld_tehsil_id").html(html);

                            }
                        });


                    }
                }
            });
        });
    </script>
@endsection
