@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.signin')
@endsection
@section('content')
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden card-bg-fill galaxy-border-none">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column" style="display: none">

                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>

                                                <div style="display:none" id="qoutescarouselIndicators"
                                                    class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                            data-bs-slide-to="0" class=""
                                                            aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                            data-bs-slide-to="1" aria-label="Slide 2" class="active"
                                                            aria-current="true"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                            data-bs-slide-to="2" aria-label="Slide 3"
                                                            class=""></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white-50 pb-5">
                                                        <div class="carousel-item active carousel-item-start">
                                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design,
                                                                easy for customization. Thanks very much! "</p>
                                                        </div>
                                                        <div class="carousel-item carousel-item-next carousel-item-start">
                                                            <p class="fs-15 fst-italic">" The theme is really great with an
                                                                amazing customer support."</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design,
                                                                easy for customization. Thanks very much! "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end carousel -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-1">
                                        <div class="pb-2">
                                            <a href="/login" class="d-block">
                                                <img src="{{ URL::asset('images/logo_c.png') }}" alt="LOGO"
                                                    height="40">
                                            </a>
                                        </div>
                                        <div>
                                            <p class="text-muted">Sign in to continue to {{ env('APP_NAME') }}.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form action="{{ route('login') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('username') is-invalid @enderror"
                                                        value="{{ old('username') }}" id="username" name="username"
                                                        placeholder="Enter username">
                                                    @error('username')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    {{-- <div class="float-end">
                                                        <a href="{{ route('password.update') }}" class="text-muted">Forgot
                                                            password?</a>
                                                    </div> --}}
                                                    <label class="form-label" for="password-input">Password <span
                                                            class="text-danger">*</span></label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password"
                                                            class="form-control password-input pe-5 @error('password') is-invalid @enderror"
                                                            name="password" placeholder="Enter password"
                                                            id="password-input">
                                                        <button
                                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                            type="button" id="password-addon"><i
                                                                class="ri-eye-fill align-middle"></i></button>
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="auth-remember-check" name="remember">
                                                    <label class="form-check-label" for="auth-remember-check">Remember
                                                        me</label>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Sign In</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <img src="{{ URL::asset('images/nebula.png') }}" alt="LOGO"
                                                        height="27">
                                                </div>

                                            </form>
                                        </div>


                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection
