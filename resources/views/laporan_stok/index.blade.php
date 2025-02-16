@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Laporan Stok Barang</h4>
            <div class="card-header-action">
                <a class="btn btn-success btn-xs btn-flat" id="export"><i class="fa fa-file-export"></i>
                    Excel</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Tanggal Pembelian</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Stok</th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('laporan_stok.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_produk'
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'tgl_kadaluarsa'
                    },
                    {
                        data: 'stok'
                    },
                ]
            });
        });

        $(document).on('click', '#export', function(e) {
            e.preventDefault();
            window.location.href = '<?= route('laporan_stok.export') ?>';
        });
    </script>
@endpush
