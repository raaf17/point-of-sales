{!! Form::model($diskon, ['id' => 'formEdit']) !!}
@include('diskon.form')
<div class="col-12 d-flex justify-content-end">
    <button type="button" class="btn btn-secondary me-1" onclick="bootbox.hideAll()">Cancel</button>
    <button type="button" class="btn btn-primary" onclick="update('{{ $diskon->id_diskon }}')">Simpan</button>
</div>
{!! Form::close() !!}