<form action="{{ route('products.update', $product->fld_pid) }}" method="POST" name="update_record">
    @method('PUT')
    @csrf

    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1 text-sm small">Edit {{ $product->fld_name }}</h4>
        </div>

        <div class="card-body">
            <div class="live-preview">

                <div class="row">

                    <div class="col-12">
                        <div class="mb-3 mt-0">
                            <label for="customer-name" class="col-form-label">Select Project </label>
                            <select class="form-control" required name="fld_p_id">
                                <option value="">Selec Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->fld_pid }}" @selected($project->fld_pid == $product->fld_p_id)>
                                        {{ $project->fld_name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="fld_name" class="form-control-label">Product Name<sup>*</sup></label>

                            <div class="@error('fld_name')border border-danger rounded-3 @enderror">
                                <input class="form-control" value="{{ old('fld_name', $product->fld_name) }}"
                                    type="text" placeholder="Enter product  name" id="fld_name" name="fld_name"
                                    required>
                                @error('fld_name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="fld_sku" class="form-control-label">SKU<sup>*</sup></label>

                            <div class="@error('fld_sku')border border-danger rounded-3 @enderror">
                                <input class="form-control" value="{{ old('fld_sku', $product->fld_sku) }}"
                                    type="text" placeholder="Enter SKU" id="fld_sku" name="fld_sku" required>
                                @error('fld_sku')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="fld_mrp" class="form-control-label">MRP<sup>*</sup></label>

                            <div class="@error('fld_mrp')border border-danger rounded-3 @enderror">
                                <input class="form-control" value="{{ old('fld_mrp', $product->fld_mrp) }}"
                                    type="text" placeholder="Enter MRP" id="fld_mrp" name="fld_mrp" required>
                                @error('fld_mrp')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="fld_cost_price" class="form-control-label">Cost
                                price<sup>*</sup></label>

                            <div class="@error('fld_cost_price')border border-danger rounded-3 @enderror">
                                <input class="form-control"
                                    value="{{ old('fld_cost_price', $product->fld_cost_price) }}" type="text"
                                    placeholder="Enter cost price" id="fld_cost_price" name="fld_cost_price" required>
                                @error('fld_cost_price')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="fld_selling_price" class="form-control-label">Selling
                                price<sup>*</sup></label>

                            <div class="@error('fld_selling_price')border border-danger rounded-3 @enderror">
                                <input class="form-control"
                                    value="{{ old('fld_selling_price', $product->fld_selling_price) }}" type="text"
                                    placeholder="Enter selling price" id="fld_selling_price" name="fld_selling_price"
                                    required>
                                @error('fld_selling_price')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="fld_type" class="form-control-label">Type</label>
                            <select class="form-control" name="fld_type" id="fld_type">
                                <option value="">Select Sale Type</option>
                                <option value="1" @selected($product->fld_type == 1)>Retail</option>
                                <option value="2" @selected($product->fld_type == 2)>Order Booking</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="fld_display_order" class="form-control-label">Display order</label>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="fld_display_order"
                                    name="fld_display_order">
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-3">
                            <label for="fld_name" class="form-control-label">Status</label>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="flexSwitchCheckChecked" checked="" value="1" name="status" />
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-6">

                        <div class="text-end d-flex gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>

                <!--end row-->
            </div>
        </div>
    </div>


</form>
