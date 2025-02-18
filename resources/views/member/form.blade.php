<div class="form-group">
    {!! Form::label('nama', 'Nama Member') !!}
    {!! Form::text('nama', null, ['class' => 'form-control', 'id' => 'nama']) !!}
</div>
<div class="form-group">
    {!! Form::label('telepon', 'Telepon') !!}
    {!! Form::text('telepon', null, ['class' => 'form-control', 'id' => 'telepon']) !!}
</div>
<div class="form-group">
    {!! Form::label('alamat', 'Alamat') !!}
    {!! Form::textarea('alamat', null, ['class' => 'form-control', 'id' => 'alamat']) !!}
</div>
<div class="form-group">
    {!! Form::label('tipe_member', 'Tipe Member') !!}
    {!! Form::select('tipe_member', ['' => 'Pilih', 'Silver' => 'Silver', 'Silver' => 'Gold', 'Diamond' => 'Diamond'], null, ['class' => 'form-select', 'id' => 'tipe_member']) !!}
</div>
