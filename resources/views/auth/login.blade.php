@extends('layouts.auth')
@section('login')
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

                <form action="{{ route('login') }}" method="post" class="form-login" id="login-form">
                    @csrf
                    <div class="form-group position-relative has-icon-left">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}" autofocus>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @error('email')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-group position-relative has-icon-left mt-4">
                        <input type="password" name="password" id="password-field" class="form-control"
                            placeholder="Password" minlength="8">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <span class="glyphicon glyphicon-eye-open field-icon toggle-password"
                        style="cursor: pointer; position: absolute; right: 10px; top: 10px;"></span>
                    @error('password')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Masuk</button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div>
                <img src="{{ asset('img') }}/background-login.jpg" alt="" style="width: 1500px">
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-password').click(function() {
                const passwordField = $('#password-field');
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
                }
            });

            $('#login-form').submit(function(event) {
                let email = $('#email').val().trim();
                let password = $('#password-field').val().trim();

                if (email === '' || password === '') {
                    event.preventDefault();
                    alert('Email dan Password harus diisi terlebih dahulu!');
                }
            });
        });
    </script>
@endpush
