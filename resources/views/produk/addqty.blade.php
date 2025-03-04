{!! Form::model($id,['id' => 'formAddStok']) !!}
<div class="form-group">
    {!! Form::label('stok', 'Stok') !!}
    {!! Form::number('stok', null, ['class' => 'form-control', 'id' => 'stok']) !!}
    <small class="text-danger error_stok"></small>
</div>
<div class="form-group">
    {!! Form::label('tgl_pembelian', 'Tanggal Pembelian') !!}
    {!! Form::date('tgl_pembelian', null, ['class' => 'form-control', 'id' => 'tgl_pembelian']) !!}
    <small class="text-danger error_tgl_pembelian"></small>
</div>
<div class="form-group">
    {!! Form::label('tgl_kadaluarsa', 'Tanggal Kadaluarsa') !!}
    {!! Form::date('tgl_kadaluarsa', null, ['class' => 'form-control', 'id' => 'tgl_kadaluarsa']) !!}
    <small class="text-danger error_tgl_kadaluarsa"></small>
</div>
<div class="col-12 d-flex justify-content-end">
    <button type="button" class="btn btn-secondary me-1" onclick="bootbox.hideAll()">Cancel</button>
    <button type="button" class="btn btn-primary" onclick="storeQty('{{ $id }}')">Simpan</button>
</div>
{!! Form::close() !!}