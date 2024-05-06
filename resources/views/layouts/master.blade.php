<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="horizontal" data-topbar="light"
    data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default"
    data-theme-colors="default" data-sidebar-visibility="show" data-layout-style="default" data-bs-theme="light"
    data-layout-width="fluid" data-layout-position="fixed" data-body-image="none">
<script>
    window._wordtune_extension_installed = true;
</script>

<head>

    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | {{ env('APP_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}">
        @include('layouts.head-css')
        <style>
            .btn-submit {
                padding: 0px;
                background: transparent;
                border: 0px;
                color: blue;
            }

            .display-none {
                display: none;
            }

            .ui-sortable-handle {
                cursor: pointer;
            }
        </style>
    </head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
        <div id="successMessage"
            style="display: none; position: fixed; bottom: -100px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 15px; border-radius: 10px; z-index: 9999;">

        </div>
    </div>
    <!-- END layout-wrapper -->

    @include('layouts.customizer')

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
</body>

</html>
