<div class="form-group">
    {!! Form::label('name', 'Nama Lengkap') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
    <small class="text-danger error_name"></small>
</div>
<div class="form-group">
    {!! Form::label('email', 'Email') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
    <small class="text-danger error_email"></small>
</div>
<div class="form-group">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
    <small class="text-danger error_password"></small>
</div>
<div class="form-group">
    {!! Form::label('level', 'Role') !!}
    {!! Form::select('level', ['' => 'Pilih', '1' => 'Administrator', '2' => 'Kasir'], null, ['class' => 'form-select', 'id' => 'level']) !!}
    <small class="text-danger error_level"></small>
</div>
