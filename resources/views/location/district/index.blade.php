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
                <form action="{{ url('/location/district') }}" method="GET">
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
                                    <th class="text-uppercase">District</th>
                                    <th class="text-uppercase">State</th>
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
                                        <td class="td">{{ $record->fld_district }}</td>

                                        <td class="td"> {{ $record->state->fld_state }}
                                        </td>

                                        <td class="td {{ $record->fld_status ? 'text-green' : 'bg-red' }}">
                                            {{ $record->fld_status ? 'Active' : 'Deactive' }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a class="ri-edit-line"
                                                    href="{{ route('district.edit', $record->fld_did) }}"></a>

                                                <form action="{{ route('district.destroy', $record->fld_did) }}"
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
        @if (request()->route()->getName() === 'district.edit')
            @include('location.district.edit', [
                'district' => $district,
                'states' => $states,
                'records' => $records,
            ])
        @else
            @include('location.district.create')
        @endif

    </div>
</div>
