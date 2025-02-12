@extends('layouts.auth')
@section('login')
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

                <form action="{{ route('login') }}" method="post" class="form-login">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" name="email" class="form-control" placeholder="Email" required
                            value="{{ old('email') }}" autofocus>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @error('email')
                        <span class="help-block">{{ $message }}</span>
                    @else
                        <span class="help-block with-errors"></span>
                    @enderror
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password" id="password-field" class="form-control"
                            placeholder="Password" required minlength="12">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <span class="glyphicon glyphicon-eye-open field-icon toggle-password"
                        style="cursor: pointer; position: absolute; right: 10px; top: 10px;"></span>
                    @error('password')
                        <span class="help-block">{{ $message }}</span>
                    @else
                        <span class="help-block with-errors"></span>
                    @enderror

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.querySelector('.toggle-password').addEventListener('click', function() {
                                const passwordField = document.querySelector('#password-field');
                                if (passwordField.type === 'password') {
                                    passwordField.type = 'text';
                                    this.classList.remove('glyphicon-eye-open');
                                    this.classList.add('glyphicon-eye-close');
                                } else {
                                    passwordField.type = 'password';
                                    this.classList.remove('glyphicon-eye-close');
                                    this.classList.add('glyphicon-eye-open');
                                }
                            });
                        });
                    </script>

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
