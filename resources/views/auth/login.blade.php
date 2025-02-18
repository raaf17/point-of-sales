@extends('layouts.auth')
@section('login')
    <div class="row h-100 justify-content-center">
        <div class="col-lg-4 col-12">
            <div class="card shadow-lg" style="margin-top: 130px">
                <div class="card-body" style="padding: 30px 60px">
                    <h1 class="auth-title text-center">Login</h1>

                    {{-- Alert Error Message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" style="margin-bottom: 30px; margin-top: 30px" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="post" class="form-login" id="login-form">
                        @csrf

                        <div class="form-group position-relative has-icon-left mt-4">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                                value="{{ old('email') }}" autofocus>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        @error('email')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror

                        <div class="form-group position-relative has-icon-left mt-4">
                            <input type="password" name="password" id="password-field" class="form-control"
                                placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        @error('password')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection