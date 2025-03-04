<div class="form-group">
    {!! Form::label('nama_produk', 'Nama Barang') !!}
    {!! Form::text('nama_produk', null, ['class' => 'form-control', 'id' => 'nama_produk']) !!}
    <small class="text-danger error_nama_produk"></small>
</div>
<div class="form-group">
    {!! Form::label('id_kategori', 'Kategori') !!}
    {!! Form::select(
        'id_kategori',
        ['' => 'Pilih'] + \App\Models\Kategori::pluck('nama_kategori', 'id_kategori')->toArray(),
        null,
        ['class' => 'form-select', 'id' => 'id_kategori'],
    ) !!}
    <small class="text-danger error_id_kategori"></small>
</div>
<div class="form-group">
    {!! Form::label('harga_beli', 'HPP') !!}
    {!! Form::number('harga_beli', null, ['class' => 'form-control', 'id' => 'harga_beli']) !!}
    <small class="text-danger error_harga_beli"></small>
</div>
<div class="form-group">
    {!! Form::label('satuan', 'Satuan') !!}
    {!! Form::select('satuan', ['' => 'Pilih', 'PCS' => 'PCS', 'BOX' => 'BOX', 'Lusin' => 'Lusin'], null, [
        'class' => 'form-select',
        'id' => 'satuan',
    ]) !!}
    <small class="text-danger error_satuan"></small>
</div>
<div class="form-group">
    {!! Form::label('minimal_stok', 'Minimal Stok') !!}
    {!! Form::number('minimal_stok', null, ['class' => 'form-control', 'id' => 'minimal_stok']) !!}
    <small class="text-danger error_minimal_stok"></small>
</div>
