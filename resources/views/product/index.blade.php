@extends('layouts.master')
@section('title')
    @lang('Product')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang('Product')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-9">
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
                                        <th class="text-uppercase">Product Name</th>
                                        <th class="text-uppercase">SKU</th>
                                        <th class="text-uppercase">MRP</th>
                                        <th class="text-uppercase">Cost Price</th>
                                        <th class="text-uppercase">Selling Price</th>
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
                                            <td class="td">{{ $record->fld_name }}</td>
                                            <td class="td"> {{ $record->fld_sku }}</td>

                                            <td class="td">{{ $record->fld_mrp }}</td>
                                            <td class="td">{{ $record->fld_cost_price }}</td>
                                            <td class="td">{{ $record->fld_selling_price }}</td>
                                            <td class="td">

                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status"
                                                        data-product-id={{ $record->fld_pid }} type="checkbox"
                                                        role="switch" id="flexSwitchCheckChecked"
                                                        @checked($record->fld_status == 1) name="status" />
                                                </div>
                                            </td>
                                            <td class="d-flex gap-2">
                                                <a href="{{ route('products.edit', $record->fld_pid) }}"><i
                                                        class="ri-eye-line"></i></a>
                                                <form onsubmit="return confirm('Do you really want to delete?');"
                                                    action="{{ route('products.destroy', $record->fld_pid) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-submit  ri-delete-bin-line">
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
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
        <div class="col-lg-3">

            @if (request()->route()->getName() === 'products.edit')
                @include('product.edit', ['product' => $product])
            @else
                @include('product.create')
            @endif

        </div>
    </div>
    <!--end row-->
    @include('product.upload')
@endsection

@section('script')
    <script src="{{ URL::asset('/build/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/build/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $(".status").change(function(e) {
                let product_id = $(this).attr('data-product-id');
                let status = ($(this).is(':checked') === false) ? 0 : 1;
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                let additionalParam = {
                    status,
                    product_id
                };
                $.ajax({
                    url: "/master/product/update-status",
                    type: "POST",
                    data: JSON.stringify(additionalParam),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                    },
                    success: function(response) {
                        showSuccessMessage('Status has been updated');
                        // Handle success
                    },
                    error: function(xhr, status, error) {
                        showSuccessMessage(xhr.responseText);
                        // Handle error
                    }
                });

            })




        });
    </script>
@endsection
