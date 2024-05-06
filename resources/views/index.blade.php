@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')
    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Hello, {{ Auth::user()->fld_name }}!</h4>
                                <p class="text-muted mb-0">Welcome to Adani Tarang!</p>
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <style>
                    .table>:not(caption)>*>* {
                        padding: 0.5rem .6rem;
                    }
                </style>
                <!--end row-->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex gap-2">
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <img src="{{ URL::asset('images/usdt.svg') }}" alt=""
                                                        class="avatar-xxs material-shadow">
                                                </div>
                                            </div>
                                            <div class="@error('fld_project_id')border border-danger rounded-3 @enderror">

                                                <select class="form-control" id="fld_project_id" name="fld_project_id"
                                                    onchange="this.options[this.selectedIndex].value && (window.location = '?project_id='+ this.options[this.selectedIndex].value);">
                                                    <option value="">Select Project</option>
                                                    @foreach ($projects as $project)
                                                        <option value="{{ $project->fld_pid }}"
                                                            @selected($project->fld_pid == $project_id)>{{ $project->fld_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('fld_project_id')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    @php
                                        $f_total_retailer = 0;
                                        $f_total_converted = 0;
                                        $f_total_purchase = 0;
                                        $f_total_retailsale = 0;
                                    @endphp
                                    <table
                                        class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0">
                                        <thead class="text-muted bg-light-subtle">
                                            <tr>
                                                <th>Van</th>
                                                <th>District </th>
                                                @if (in_array(Auth::user()->fld_role, [1, 3, 5]))
                                                    <th>Working Days <br />(Total: {{ $totalDaysDifference }})</th>
                                                @endif
                                                <th>Total Retailer <br /> Coverage</th>
                                                <th>Converted <br /> Outlets</th>
                                                <th>Total Purchase (₹)</th>
                                                <th>Total Sales (₹)</th>
                                            </tr>
                                        </thead><!-- end thead -->
                                        <tbody>
                                            @forelse ($users as $user)
                                                <tr>
                                                    <td>{{ $user->fld_name }}</td>
                                                    <td>
                                                        @foreach ($user->routePlan as $di)
                                                            {{ $di->district->fld_district }}
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    @if (in_array(Auth::user()->fld_role, [1, 3, 5]))
                                                        <td>{{ $user->attendances_count }} </td>
                                                    @endif

                                                    <td>{{ $user->total_retailers_count }} </td>
                                                    <td>
                                                        @php $total_converted_outlets=0 @endphp
                                                        @forelse ($user->totalRetailers as $retailer)
                                                            @if (count($retailer->retailSaleCount))
                                                                @php $total_converted_outlets++; @endphp
                                                            @endif
                                                        @empty
                                                            0
                                                        @endforelse
                                                        {{ $total_converted_outlets }}
                                                    </td>
                                                    <td>{{ $user->total_purchase_sum_fld_total != null ? $user->total_purchase_sum_fld_total : 0 }}
                                                    </td>
                                                    <td>{{ $user->total_retailsales_sum_fld_total != null ? $user->total_retailsales_sum_fld_total : 0 }}
                                                    </td>

                                                </tr><!-- end -->
                                                @php
                                                    $f_total_retailer += $user->total_retailers_count;
                                                    $f_total_converted += $total_converted_outlets;
                                                    $f_total_purchase +=
                                                        $user->total_purchase_sum_fld_total != null
                                                            ? $user->total_purchase_sum_fld_total
                                                            : 0;
                                                    $f_total_retailsale +=
                                                        $user->total_retailsales_sum_fld_total != null
                                                            ? $user->total_retailsales_sum_fld_total
                                                            : 0;
                                                @endphp
                                            @empty
                                                <tr>
                                                    <td colspan="7">
                                                        <p>No record found</p>
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody><!-- end tbody -->
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                @if (in_array(Auth::user()->fld_role, [1, 3, 5]))
                                                    <td></td>
                                                @endif
                                                <td><b>{{ $f_total_retailer }} </b> </td>
                                                <td><b>{{ $f_total_converted }} </b> </td>
                                                <td><b>{{ $f_total_purchase }} </b> </td>
                                                <td><b>{{ $f_total_retailsale }} </b> </td>
                                            </tr>
                                        </tfoot>
                                    </table><!-- end table -->
                                </div><!-- end tbody -->
                            </div><!-- end cardbody -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-4" style="display: none">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center border-0 d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Trading</h4>
                                <div class="flex-shrink-0">
                                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0"
                                        role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#buy-tab" role="tab"
                                                aria-selected="true">Buy</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#sell-tab" role="tab"
                                                aria-selected="false" tabindex="-1">Sell</a>
                                        </li>
                                    </ul><!-- end ul -->
                                </div>
                            </div><!-- end cardheader -->
                            <div class="card-body p-0">
                                <div class="tab-content p-0">
                                    <div class="tab-pane active" id="buy-tab" role="tabpanel">
                                        <div class="p-3 bg-warning-subtle">
                                            <div class="float-end ms-2">
                                                <h6 class="text-warning mb-0">USD Balance : <span
                                                        class="text-body">$12,426.07</span></h6>
                                            </div>
                                            <h6 class="mb-0 text-danger">Buy Coin</h6>
                                        </div>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label>Currency :</label>
                                                        <select class="form-select">
                                                            <option>BTC</option>
                                                            <option>ETH</option>
                                                            <option>LTC</option>
                                                        </select>
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label>Payment Method :</label>
                                                        <select class="form-select">
                                                            <option>Wallet Balance</option>
                                                            <option>Credit / Debit Card</option>
                                                            <option>PayPal</option>
                                                            <option>Payoneer</option>
                                                        </select>
                                                    </div>
                                                </div><!-- end col -->
                                            </div><!-- end row -->
                                            <div>
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text">Amount</label>
                                                    <input type="text" class="form-control" placeholder="0">
                                                </div>

                                                <div class="input-group mb-3">
                                                    <label class="input-group-text">Price</label>
                                                    <input type="text" class="form-control" placeholder="2.045585">
                                                    <label class="input-group-text">$</label>
                                                </div>

                                                <div class="input-group mb-0">
                                                    <label class="input-group-text">Total</label>
                                                    <input type="text" class="form-control" placeholder="2700.16">
                                                </div>
                                            </div>
                                            <div class="mt-3 pt-2">
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <p class="fs-13 mb-0">Transaction Fees<span
                                                                class="text-muted ms-1 fs-11">(0.05%)</span></p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h6 class="mb-0">$1.08</h6>
                                                    </div>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <p class="fs-13 mb-0">Minimum Received<span
                                                                class="text-muted ms-1 fs-11">(2%)</span></p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h6 class="mb-0">$7.85</h6>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="fs-13 mb-0">Estimated Rate</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h6 class="mb-0">1 BTC ~ $34572.00</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 pt-2">
                                                <button type="button" class="btn btn-primary w-100">Buy Coin</button>
                                            </div>
                                        </div>
                                    </div><!-- end tabpane -->

                                    <div class="tab-pane" id="sell-tab" role="tabpanel">
                                        <div class="p-3 bg-warning-subtle">
                                            <div class="float-end ms-2">
                                                <h6 class="text-warning mb-0">USD Balance : <span
                                                        class="text-body">$12,426.07</span></h6>
                                            </div>
                                            <h6 class="mb-0 text-danger">Sell Coin</h6>
                                        </div>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label>Currency :</label>
                                                        <select class="form-select">
                                                            <option>BTC</option>
                                                            <option>ETH</option>
                                                            <option>LTC</option>
                                                        </select>
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label>Email :</label>
                                                        <input type="email" class="form-control"
                                                            placeholder="example@email.com">
                                                    </div>
                                                </div><!-- end col -->
                                            </div><!-- end row -->
                                            <div>
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text">Amount</label>
                                                    <input type="text" class="form-control" placeholder="0">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text">Price</label>
                                                    <input type="text" class="form-control" placeholder="2.045585">
                                                    <label class="input-group-text">$</label>
                                                </div>
                                                <div class="input-group mb-0">
                                                    <label class="input-group-text">Total</label>
                                                    <input type="text" class="form-control" placeholder="2700.16">
                                                </div>
                                            </div>
                                            <div class="mt-3 pt-2">
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <p class="fs-13 mb-0">Transaction Fees<span
                                                                class="text-muted ms-1 fs-11">(0.05%)</span></p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h6 class="mb-0">$1.08</h6>
                                                    </div>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <p class="fs-13 mb-0">Minimum Received<span
                                                                class="text-muted ms-1 fs-11">(2%)</span></p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h6 class="mb-0">$7.85</h6>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="fs-13 mb-0">Estimated Rate</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h6 class="mb-0">1 BTC ~ $34572.00</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 pt-2">
                                                <button type="button" class="btn btn-danger w-100">Sell Coin</button>
                                            </div>
                                        </div>
                                    </div><!-- end tab pane -->
                                </div><!-- end tab pane -->
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>

            </div> <!-- end .h-100-->

        </div> <!-- end col -->

    </div>
@endsection
@section('script')
    <!-- apexcharts -->
    <!-- dashboard init -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
