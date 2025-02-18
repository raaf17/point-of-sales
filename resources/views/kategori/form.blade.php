<div class="form-group">
    {!! Form::label('nama_kategori', 'Nama Kategori') !!}
    {!! Form::text('nama_kategori', null, ['class' => 'form-control', 'id' => 'nama_kategori']) !!}
</div>
<div class="form-group">
    {!! Form::label('warna', 'Tipe Kendaraan') !!}
    {!! Form::select('warna', ['' => 'Pilih', 'primary' => 'Primary', 'success' => 'Success', 'secondary' => 'Secondary', 'info' => 'Info', 'danger' => 'Danger'], null, ['class' => 'form-select', 'id' => 'warna']) !!}
</div>
