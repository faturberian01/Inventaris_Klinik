@extends('layouts.auth')

@section('content')
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-gradient-primary">
                                <div class="h-100 w-100 d-flex align-items-center justify-content-center ">
                                    <img src="{{ asset('images/logo2.png') }}" alt="Logo" width="200" class="d-block"
                                        style="filter: brightness(0) invert(1);">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <small class="h6 text-gray-900 d-block mb-2">Reset Password</small>
                                        <h1 class="h2 text-gray-900 mb-4 font-weight-bold">Please Input New Password</h1>
                                    </div>
                                    <form class="user" action="{{ route('password.update') }}" method="POST">
                                        @csrf

                                        @include('partials.validation-alerts')
                                        @include('partials.alerts')

                                        <div class="form-group">
                                            <input type="hidden" name="email" value="{{ request('email') }}" />
                                            <input type="hidden" name="token" value="{{ request('token') }}" />

                                            <div class="form-group">
                                                <input type="password" name="password"
                                                    class="form-control form-control-user" id="exampleInputPassword"
                                                    placeholder="Password">
                                            </div>

                                            <div class="form-group">
                                                <input type="password" name="password_confirmation"
                                                    class="form-control form-control-user" id="exampleInputPassword"
                                                    placeholder="Confirm Password">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block fw-bold">
                                            Send
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
