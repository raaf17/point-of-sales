{{-- <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="{{ route('penjualan.data') }}" method="get" data-toggle="validator" class="form-horizontal" id="modalFilter">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Periode Laporan</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tanggal_awal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Awal</label>
                        <div class="col-lg-10">
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control datepicker" required autofocus
                                value="{{ request('tanggal_awal') }}"
                                style="border-radius: 0 !important;">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_akhir" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Akhir</label>
                        <div class="col-lg-10">
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control datepicker" required
                                value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}"
                                style="border-radius: 0 !important;">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-flat btn-warning" data-bs-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}

{!! Form::open(['route' => 'penjualan.data', 'method' => 'get', 'id' => 'filterForm']) !!}
<div class="form-group">
    {!! Form::label('tanggal_awal', 'Tanggal Awal') !!}
    {!! Form::date('tanggal_awal', request('tanggal_awal'), [
        'class' => 'form-control datepicker',
        'id' => 'tanggal_awal',
        'required',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('tanggal_akhir', 'Tanggal Akhir') !!}
    {!! Form::date('tanggal_akhir', request('tanggal_akhir', date('Y-m-d')), [
        'class' => 'form-control datepicker',
        'id' => 'tanggal_akhir',
        'required',
    ]) !!}
</div>
<div class="col-12 d-flex justify-content-end">
    <button type="reset" class="btn btn-danger me-1">Reset</button>
    <button type="button" class="btn btn-secondary me-1" onclick="bootbox.hideAll()">Cancel</button>
    <button type="button" class="btn btn-primary" onclick="applyFilter()">Simpan</button>
</div>
{!! Form::close() !!}
