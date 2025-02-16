<div class="form-group">
    {!! Form::label('nama_diskon', 'Nama Diskon') !!}
    {!! Form::text('nama_diskon', null, ['class' => 'form-control', 'id' => 'nama_diskon']) !!}
</div>
<div class="form-group">
    {!! Form::label('tipe_member_id', 'Tipe Member') !!}
    {!! Form::text('tipe_member_id', null, ['class' => 'form-control', 'id' => 'tipe_member_id']) !!}
</div>
<div class="form-group">
    {!! Form::label('min_diskon', 'Min. Diskon') !!}
    {!! Form::number('min_diskon', null, ['class' => 'form-control', 'id' => 'min_diskon']) !!}
</div>
<div class="form-group">
    {!! Form::label('max_diskon', 'Max. Diskon') !!}
    {!! Form::number('max_diskon', null, ['class' => 'form-control', 'id' => 'max_diskon']) !!}
</div>
<div class="form-group">
    {!! Form::label('diskon', 'Diskon') !!}
    {!! Form::number('diskon', null, ['class' => 'form-control', 'id' => 'diskon']) !!}
</div>
<div class="form-group">
    {!! Form::label('tgl_mulai', 'Tanggal Mulai') !!}
    {!! Form::date('tgl_mulai', null, ['class' => 'form-control', 'id' => 'tgl_mulai']) !!}
</div>
<div class="form-group">
    {!! Form::label('tgl_berakhir', 'Tanggal Berakhir') !!}
    {!! Form::date('tgl_berakhir', null, ['class' => 'form-control', 'id' => 'tgl_berakhir']) !!}
</div>
