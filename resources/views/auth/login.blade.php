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
                            <div class="col-lg-6 d-none d-lg-block bg-white">
                                <div class="">
                                    <img src="{{ asset('images/klinik.png') }}" alt="Logo" width="200" class="h-100 w-100 d-flex align-items-center justify-content-center "
                                        style="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <small class="h6 text-gray-900 d-block mb-2">Welcome To</small>
                                        <h1 class="h2 text-gray-900 mb-4 font-weight-bold">MA Medika!</h1>
                                    </div>
                                    <form class="user" action="{{ route('auth.login') }}" method="POST">
                                        @csrf

                                        @include('partials.validation-alerts')
                                        @include('partials.alerts')

                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small" name>
                                                <input type="checkbox" class="custom-control-input" id="customCheck"
                                                    name="remember">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block fw-bold">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <a href="{{ route('auth.forgot') }}" class="d-block text-center">Forgot Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
