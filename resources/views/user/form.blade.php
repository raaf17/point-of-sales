<div class="form-group">
    {!! Form::label('name', 'Nama Lengkap') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>
<div class="form-group">
    {!! Form::label('email', 'Email') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
</div>
<div class="form-group">
    {!! Form::label('password', 'Password') !!}
    {!! Form::number('password', null, ['class' => 'form-control', 'id' => 'password']) !!}
</div>
<div class="form-group">
    {!! Form::label('password_confirmation', 'Konfirmasi Password') !!}
    {!! Form::number('password_confirmation', null, ['class' => 'form-control', 'id' => 'password_confirmation']) !!}
</div>
@push('scripts')
    <script>
        function validateForm(input) {
            var passwordInput = document.getElementById('password');
            var password = passwordInput.value;

            var regex = /^(?=.[A-Z])(?=.[a-z])(?=.\d)(?=.[@$!%?&])[A-Za-z\d@$!%?&]{12,}$/;

            var isValid = regex.test(password);

            var errorMessage = '';
            if (!isValid) {
                errorMessage = 'Password minimal berisikan 12 karakter, 1 Kapital, Huruf kecil, Angka, Karakter khusus.';
            }

            var errorElement = passwordInput.parentElement.querySelector('.help-block');
            errorElement.textContent = errorMessage;
            errorElement.style.color = isValid ? '' : 'red';
            passwordInput.style.border = isValid ? '' : '1px solid red';

            return isValid;
        }
    </script>
@endpush
