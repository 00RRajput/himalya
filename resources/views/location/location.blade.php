@extends('layouts.master')
@section('title')
    @lang('Location')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('titleHeading')
            Location
        @endslot
        @slot('title')
            Location
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div id="invoiceList">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link mb-2 @if (in_array(Route::currentRouteName(), ['district.edit', 'district.index'])) active @endif"
                                        href="{{ route('district.index') }}" role="tab" aria-controls="v-pills-home"
                                        aria-selected="true">District</a>
                                    <a class="nav-link mb-2 @if (in_array(Route::currentRouteName(), ['tehsil.edit', 'tehsil.index'])) active @endif"
                                        href="{{ route('tehsil.index') }}" role="tab" aria-controls="v-pills-profile"
                                        aria-selected="false" tabindex="-1">Tehsil</a>
                                    <a class="nav-link mb-2 @if (in_array(Route::currentRouteName(), ['village.edit', 'village.index'])) active @endif"
                                        href="{{ route('village.index') }}" role="tab" aria-controls="v-pills-messages"
                                        aria-selected="false" tabindex="-1">Village</a>
                                </div>
                            </div><!-- end col -->
                            <div class="col-11">
                                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                    <div class="tab-pane fade @if (in_array(Route::currentRouteName(), ['district.edit', 'district.index'])) active show @endif"
                                        id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <div class="d-flex mb-2">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-4.jpg" alt="" width="150"
                                                    class="rounded">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                @if (in_array(Route::currentRouteName(), ['district.edit', 'district.index']))
                                                    @include('location.district.index', [
                                                        'states' => $states,
                                                        'records' => $records,
                                                    ]);
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade @if (in_array(Route::currentRouteName(), ['tehsil.edit', 'tehsil.index'])) active show @endif"
                                        id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                        <div class="d-flex mb-2">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-5.jpg" alt="" width="150"
                                                    class="rounded">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                @if (in_array(Route::currentRouteName(), ['tehsil.edit', 'tehsil.index']))
                                                    @include('location.tehsil.index', [
                                                        'states' => $states,
                                                        'records' => $records,
                                                    ]);
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade @if (in_array(Route::currentRouteName(), ['village.edit', 'village.index'])) active show @endif"
                                        id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                        <div class="d-flex mb-2">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-6.jpg" alt="" width="150"
                                                    class="rounded">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                @if (in_array(Route::currentRouteName(), ['village.edit', 'village.index']))
                                                    @include('location.village.index', [
                                                        'states' => $states,
                                                        'records' => $records,
                                                    ]);
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div><!--  end col -->
                        </div>
                        <!--end row-->
                    </div><!-- end card-body -->
                </div>
            </div>

        </div>
    </div>
    <!--end row-->
@endsection

@section('script')
    <script src="{{ URL::asset('/build/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/build/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
@endsection
