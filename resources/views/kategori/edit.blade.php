{!! Form::model($kategori, ['id' => 'formEdit']) !!}
@include('kategori.form')
<div class="col-12 d-flex justify-content-end">
    <button type="button" class="btn btn-secondary me-1" onclick="bootbox.hideAll()">Cancel</button>
    <button type="button" class="btn btn-primary" onclick="update('{{ $kategori->id_kategori }}')">Simpan</button>
</div>
{!! Form::close() !!}