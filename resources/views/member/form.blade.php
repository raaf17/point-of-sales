<div class="form-group">
    {!! Form::label('nama', 'Nama Member') !!}
    {!! Form::text('nama', null, ['class' => 'form-control', 'id' => 'nama']) !!}
    <small class="text-danger error_nama"></small>
</div>
<div class="form-group">
    {!! Form::label('telepon', 'Telepon') !!}
    {!! Form::number('telepon', null, ['class' => 'form-control', 'id' => 'telepon']) !!}
    <small class="text-danger error_telepon"></small>
</div>
<div class="form-group">
    {!! Form::label('alamat', 'Alamat') !!}
    {!! Form::textarea('alamat', null, ['class' => 'form-control', 'id' => 'alamat']) !!}
    <small class="text-danger error_alamat"></small>
<div class="form-group">
    {!! Form::label('tipe_member', 'Tipe Member') !!}
    {!! Form::select('tipe_member', ['' => 'Pilih', 'Silver' => 'Silver', 'Gold' => 'Gold', 'Diamond' => 'Diamond'], null, ['class' => 'form-select', 'id' => 'tipe_member']) !!}
    <small class="text-danger error_tipe_member"></small>
</div>
