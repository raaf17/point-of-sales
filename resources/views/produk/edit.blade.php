{!! Form::model($produk, ['id' => 'formEdit']) !!}
@include('produk.form')
<div class="col-12 d-flex justify-content-end">
    <button type="button" class="btn btn-secondary me-1" onclick="bootbox.hideAll()">Cancel</button>
    <button type="button" class="btn btn-primary" onclick="update('{{ $produk->id_produk }}')">Simpan</button>
</div>
{!! Form::close() !!}