@extends('layouts.master')
@section('title')
    @lang('Client')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang('Client')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-6">
            <div class="card" id="invoiceList">
                @if (session('success'))
                    <div class="m-3  alert bg-success alert-dismissible  show" id="alert-success" role="alert">
                        <span class="alert-text text-white">
                            {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                        </button>
                    </div>
                @endif

                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap" id="">
                                <thead class="text-muted">
                                    <tr>

                                        <th class="text-uppercase">#</th>
                                        <th class="text-uppercase">Client Name</th>
                                        <th class="text-uppercase">Status</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="">
                                    @forelse ($records as $key => $record)
                                        <tr>
                                            <td>{{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}</a>
                                            </td>
                                            <td class="td">{{ $record->fld_name }}</td>
                                            <td class="td {{ $record->fld_status ? 'text-green' : 'bg-red' }}">
                                                {{ $record->fld_status ? 'Active' : 'Deactive' }}</td>
                                            <td>

                                                <form action="{{ route('clients.destroy', $record->fld_cid) }}"
                                                    method="POST">

                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('clients.edit', $record->fld_cid) }}">Edit</a>

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
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
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ invoices We did not find any
                                        invoices for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2" style="display: flex;">
                                {{ $records->appends(request()->except('page'))->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-labelledby="deleteOrderLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>You are about to delete a user ?</h4>
                                        <p class="text-muted fs-15 mb-4">Deleting your user will remove all of your
                                            information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                    class="ri-close-line me-1 align-middle"></i> Close</button>
                                            <a href="" class="btn btn-danger" id="delete-record">Yes, Delete
                                                It</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            @if (request()->route()->getName() === 'clients.edit')
                @include('client.edit', ['client' => $client])
            @else
                @include('client.create')
            @endif

        </div>
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".delete_user").click(function(e) {
                let id = $(this).attr('data-id');
                let url = `Client/destroy/${id}`;
                $("#delete-record").attr('href', url)
            })
        });
    </script>
@endsection
