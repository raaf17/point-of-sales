<div class="form-group">
    {!! Form::label('nama_kategori', 'Nama Kategori') !!}
    {!! Form::text('nama_kategori', null, ['class' => 'form-control', 'id' => 'nama_kategori']) !!}
    <small class="text-danger error_nama_kategori"></small>
</div>
<div class="form-group">
    {!! Form::label('warna', 'Warna') !!}
    {!! Form::select('warna', ['' => 'Pilih', 'primary' => 'Primary', 'success' => 'Success', 'secondary' => 'Secondary', 'info' => 'Info', 'danger' => 'Danger'], null, ['class' => 'form-select', 'id' => 'warna']) !!}
    <small class="text-danger error_warna"></small>
</div>
