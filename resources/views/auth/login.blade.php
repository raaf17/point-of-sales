{{-- @extends('layouts.auth')
@section('login')
    <div class="row h-100 justify-content-center">
        <div class="col-lg-4 col-12">
            <div class="card shadow-lg" style="margin-top: 130px">
                <div class="card-body" style="padding: 30px 60px">
                    <h1 class="auth-title text-center">Login</h1>

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
@endsection --}}

@extends('layouts.auth')
@section('login')
    <div class="row h-100 justify-content-center">
        <div class="col-lg-4 col-12">
            <div class="card shadow-lg" style="margin-top: 130px">
                <div class="card-body" style="padding: 30px 60px">
                    <h1 class="auth-title text-center">Login</h1>

                    {{-- Alert Error Message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show"
                            style="margin-bottom: 30px; margin-top: 30px" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div id="validation-alert" class="alert alert-danger d-none"
                        style="margin-bottom: 30px; margin-top: 30px">
                        <ul class="mb-0" id="validation-errors"></ul>
                        <button type="button" class="btn-close"
                            onclick="document.getElementById('validation-alert').classList.add('d-none')"
                            aria-label="Close"></button>
                    </div>

                    <form action="{{ route('login') }}" method="post" class="form-login" id="login-form">
                        @csrf

                        <div class="form-group position-relative has-icon-left mt-4">
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email"
                                value="{{ old('email') }}" autofocus>
                        </div>

                        <div class="form-group position-relative has-icon-left mt-4">
                            <div class="input-group">
                                <input type="password" name="password" id="password-field" class="form-control"
                                    placeholder="Password">
                                <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                                    <i class="bi bi-eye" id="eye-icon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("login-form").addEventListener("submit", function(event) {
            event.preventDefault();
            let email = document.getElementById("email").value;
            let password = document.getElementById("password-field").value;
            let errors = [];
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let passwordPattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

            if (!email) {
                errors.push("Email harus diisi.");
            } else if (!emailPattern.test(email)) {
                errors.push("Format email tidak valid.");
            }

            if (!password) {
                errors.push("Password harus diisi.");
            } else if (!passwordPattern.test(password)) {
                errors.push("Password harus minimal 8 karakter, mengandung satu huruf kapital, dan satu angka.");
            }

            if (errors.length > 0) {
                let errorList = document.getElementById("validation-errors");
                errorList.innerHTML = "";
                errors.forEach(error => {
                    let li = document.createElement("li");
                    li.textContent = error;
                    errorList.appendChild(li);
                });
                document.getElementById("validation-alert").classList.remove("d-none");
            } else {
                this.submit();
            }
        });

        document.getElementById("toggle-password").addEventListener("click", function() {
            let passwordField = document.getElementById("password-field");
            let eyeIcon = document.getElementById("eye-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("bi-eye");
                eyeIcon.classList.add("bi-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("bi-eye-slash");
                eyeIcon.classList.add("bi-eye");
            }
        });
    </script>
@endsection
