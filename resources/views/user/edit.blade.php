{!! Form::model($user, ['id' => 'formEdit']) !!}
@include('user.form')
<div class="col-12 d-flex justify-content-end">
    <button type="button" class="btn btn-secondary me-1" onclick="bootbox.hideAll()">Cancel</button>
    <button type="button" class="btn btn-primary" onclick="update('{{ $user->id_user }}')">Simpan</button>
</div>
{!! Form::close() !!}