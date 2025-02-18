<div class="form-group">
    {!! Form::label('nama_produk', 'Nama Barang') !!}
    {!! Form::text('nama_produk', null, ['class' => 'form-control', 'id' => 'nama_produk']) !!}
</div>
<div class="form-group">
    {!! Form::label('id_kategori', 'Kategori') !!}
    {!! Form::select(
        'id_kategori',
        ['' => 'Pilih'] + \App\Models\Kategori::pluck('nama_kategori', 'id_kategori')->toArray(),
        null,
        ['class' => 'form-select', 'id' => 'id_kategori'],
    ) !!}
</div>
<div class="form-group">
    {!! Form::label('harga_beli', 'HPP') !!}
    {!! Form::number('harga_beli', null, ['class' => 'form-control', 'id' => 'harga_beli']) !!}
</div>
<div class="form-group">
    {!! Form::label('satuan', 'Satuan') !!}
    {!! Form::select('satuan', ['' => 'Pilih', 'PCS' => 'PCS', 'BOX' => 'BOX', 'Lusin' => 'Lusin'], null, ['class' => 'form-select', 'id' => 'satuan']) !!}
</div>
<div class="form-group">
    {!! Form::label('stok', 'Stok') !!}
    {!! Form::number('stok', null, ['class' => 'form-control', 'id' => 'stok']) !!}
</div>
<div class="form-group">
    {!! Form::label('diskon', 'Diskon') !!}
    {!! Form::number('diskon', null, ['class' => 'form-control', 'id' => 'diskon']) !!}
</div>
<div class="form-group">
    {!! Form::label('minimal_stok', 'Minimal Stok') !!}
    {!! Form::number('minimal_stok', null, ['class' => 'form-control', 'id' => 'minimal_stok']) !!}
</div>
<div class="form-group">
    {!! Form::label('tgl_kadaluarsa', 'Tanggal Kadaluarsa') !!}
    {!! Form::date('tgl_kadaluarsa', null, ['class' => 'form-control', 'id' => 'tgl_kadaluarsa']) !!}
</div>
