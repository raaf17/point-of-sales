@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Laporan Stok Barang</h4>
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

    @includeIf('produk.form')
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
                columns: [
                    {
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
    </script>
@endpush
