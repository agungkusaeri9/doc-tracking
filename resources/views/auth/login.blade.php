@extends('auth.app')
@section('title')
    Login
@endsection
@push('styles')
    <style>
        .kiri{
            background-image: url("{{ asset('assets/images/gedung.png') }}");
            background-repeat:no-repeat;
            background-size:contain;
            height:100vh;
            background-position-y: 100%;
            background-color: #E7ECF8;
        }
        .logo{
            height:60px
        }
        .brand-logo{
            margin-top: 60px;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .br{
            margin-bottom: 80px !important;
        }
        .auth-form-light{
            padding:0 100px;
        }
        .kanan{
            height: 100vh;
        }
    </style>
@endpush
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-7 kiri">

        </div>
        <div class="col-md-5 kanan">
            <div class="auth-form-light text-left">
                <div class="brand-logo d-flex justify-content-start mb-5">
                    <img src="{{ asset('assets/images/polindra.png') }}" alt="logo" class="logo img-fluid">
                    <h3 class="align-self-center ml-3 font-weight-bold">Document Tracking</h3>
                </div>
                <h6 class="font-weight-light mb-4 br">Please sign-in to your account and continue to the dashboard.</h6>
                <form class="pt-3" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="email"
                            class="form-control @error('email') is-invalid @enderror form-control-lg"
                            id="exampleInputEmail1" placeholder="Email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password"
                            class="form-control @error('password') is-invalid @enderror form-control-lg"
                            id="password" placeholder="Password" name="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" name="rememberme" class="form-check-input">
                                Ingat Saya
                            </label>
                        </div>

                    </div>
                    <div class="mt-3">
                        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN
                            IN</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
    {{-- <div class="container-fluid">
        <div class="content-wrapper">
            <div class="row w-100 mx-0">
                <div class="col-lg-6 my-0 py-0 bg-danger"
                    style="background-image: url('{{ asset('assets/images/gedung.png') }}');background-repeat:no-repeat;">

                </div>
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                        </div>
                        <h4>Hello! let's get started</h4>
                        <h6 class="font-weight-light">Sign in to continue.</h6>
                        <form class="pt-3" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror form-control-lg"
                                    id="exampleInputEmail1" placeholder="Email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror form-control-lg"
                                    id="password" placeholder="Password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN
                                    IN</button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" name="rememberme" class="form-check-input">
                                        Keep me signed in
                                    </label>
                                </div>

                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div> --}}
@endsection
