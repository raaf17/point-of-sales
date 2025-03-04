<div class="form-group">
    {!! Form::label('nama_diskon', 'Nama Diskon') !!}
    {!! Form::text('nama_diskon', null, ['class' => 'form-control', 'id' => 'nama_diskon']) !!}
    <small class="text-danger error_nama_diskon"></small>
</div>
<div class="form-group">
    {!! Form::label('min_diskon', 'Min. Diskon') !!}
    {!! Form::number('min_diskon', null, ['class' => 'form-control', 'id' => 'min_diskon']) !!}
    <small class="text-danger error_min_diskon"></small>
</div>
<div class="form-group">
    {!! Form::label('max_diskon', 'Max. Diskon') !!}
    {!! Form::number('max_diskon', null, ['class' => 'form-control', 'id' => 'max_diskon']) !!}
    <small class="text-danger error_max_diskon"></small>
</div>
<div class="form-group">
    {!! Form::label('diskon', 'Diskon') !!}
    {!! Form::number('diskon', null, ['class' => 'form-control', 'id' => 'diskon']) !!}
    <small class="text-danger error_diskon"></small>
</div>
<div class="form-group">
    {!! Form::label('tgl_mulai', 'Tanggal Mulai') !!}
    {!! Form::date('tgl_mulai', null, ['class' => 'form-control', 'id' => 'tgl_mulai']) !!}
    <small class="text-danger error_tgl_mulai"></small>
</div>
<div class="form-group">
    {!! Form::label('tgl_berakhir', 'Tanggal Berakhir') !!}
    {!! Form::date('tgl_berakhir', null, ['class' => 'form-control', 'id' => 'tgl_berakhir']) !!}
    <small class="text-danger error_tgl_berakhir"></small>
</div>
