@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Setting Toko</h4>
        </div>
        <div class="card-body">
            <form action="" method="" class="form-setting" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="alert alert-info alert-dismissible" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i> Perubahan berhasil disimpan
                    </div>
                    <div class="form-group row">
                        <label for="nama_perusahaan" class="col-lg-2 control-label">Nama Toko</label>
                        <div class="col-lg-10">
                            <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telepon" class="col-lg-2 control-label">No. Telepon</label>
                        <div class="col-lg-10">
                            <input type="text" name="telepon" class="form-control" id="telepon" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-lg-2 control-label">Alamat</label>
                        <div class="col-lg-10">
                            <textarea name="alamat" class="form-control" id="alamat" rows="3" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="path_logo" class="col-lg-2 control-label">Logo</label>
                        <div class="col-lg-7">
                            <input type="file" name="path_logo" class="form-control" id="path_logo"
                                onchange="preview('.tampil-logo', this.files[0])">
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="col-lg-3">
                            <div class="p-3 shadow-sm" style="border-radius: 8px">
                                <div class="tampil-logo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe_nota" class="col-lg-2 control-label">Tipe Nota</label>
                        <div class="col-lg-10">
                            <select name="tipe_nota" class="form-select" id="tipe_nota" required>
                                <option value="1">Nota Kecil</option>
                                <option value="2">Nota Besar</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button class="btn btn-flat btn-primary" onclick="store()"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            showData();
        });

        function store() {
            var formData = new FormData($('.form-setting')[0]);

            $.ajax({
                url: '{{ route('setting.update') }}',
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success('Success', response.message);
                    } else {
                        toastr.error('Failed', response.message);
                    }
                    bootbox.hideAll();
                },
                error: function(error) {
                    var response = JSON.parse(error.responseText);
                    $('.form-setting').prepend(validation(response))
                }
            })
        }

        function showData() {
            $.get('{{ route('setting.show') }}')
                .done(response => {
                    $('[name=nama_perusahaan]').val(response.nama_perusahaan);
                    $('[name=telepon]').val(response.telepon);
                    $('[name=alamat]').val(response.alamat);
                    $('[name=diskon]').val(response.diskon);
                    $('[name=tipe_nota]').val(response.tipe_nota);
                    $('title').text(response.nama_perusahaan + ' | Pengaturan');

                    let words = response.nama_perusahaan.split(' ');
                    let word = '';
                    words.forEach(w => {
                        word += w.charAt(0);
                    });
                    $('.logo-mini').text(word);
                    $('.logo-lg').text(response.nama_perusahaan);

                    $('.tampil-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="200">`);
                    $('.tampil-kartu-member').html(
                        `<img src="{{ url('/') }}${response.path_kartu_member}" width="300">`);
                    $('[rel=icon]').attr('href', `{{ url('/') }}/${response.path_logo}`);
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                });
        }
    </script>
@endpush
