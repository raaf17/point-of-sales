@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title fs-4">Total Pendapatan : <b>{{ 'Rp. ' . number_format($pendapatan, 2, ',', '.') }}</b></h4>
            <div class="card-header-action">
                <button onclick="updatePeriode()" class="btn btn-info btn-xs btn-flat"><i class="fa fa-exchange-alt"></i>
                    Ubah Periode</button>
                <a class="btn btn-success btn-xs btn-flat" id="export"><i class="fa fa-file-export"></i>
                    Excel</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-penjualan table-bordered">
                    <thead>
                        <th width="5%">No.</th>
                        <th>Kasir</th>
                        <th>Tanggal & Waktu Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Tipe Pelanggan</th>
                        <th>Total Pembelanjaan</th>
                        <th>Diskon (Rp.)</th>
                        <th>Poin Used</th>
                        <th>Total Akhir</th>
                        <th width="8%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @includeIf('penjualan.detail')
    @includeIf('penjualan.form')
@endsection

@push('scripts')
    <script>
        let table, table1;

        $(function() {
            table = $('.table-penjualan').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('penjualan.data') }}',
                    data: function(d) {
                        d.tanggal_awal = $('#tanggal_awal').val();
                        d.tanggal_akhir = $('#tanggal_akhir').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kasir'
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'tipe_member'
                    },
                    {
                        data: 'total_harga'
                    },
                    {
                        data: 'diskon'
                    },
                    {
                        data: 'poin'
                    },
                    {
                        data: 'bayar'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            table1 = $('.table-detail').DataTable({
                processing: true,
                bSort: false,
                dom: 'Brt',
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
                        data: 'harga_jual'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'subtotal'
                    },
                ]
            })

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });

        $('#modalFilter').on('submit', function(e) {
            e.preventDefault();
            $('#modal-form').modal('hide');
            table.ajax.reload();
        });

        function showDetail(url) {
            $('#modal-detail').modal('show');

            table1.ajax.url(url);
            table1.ajax.reload();
        }

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }

        function updatePeriode() {
            $('#modal-form').modal('show');
        }

        $(document).on('click', '#export', function(e) {
            e.preventDefault();
            window.location.href = '<?= route('penjualan.export') ?>';
        });
    </script>
@endpush
