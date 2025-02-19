@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title fs-4">Data Laporan Penjualan</b></h4>
            <div class="card-header-action">
                <button onclick="filter()" class="btn btn-info btn-xs btn-flat"><i class="fa fa-calendar-alt"></i>
                    Ubah Periode</button>
                <a class="btn btn-danger btn-xs btn-flat" id="exportPdfBtn"><i class="fa fa-file"></i>
                    PDF</a>
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

        function showDetail(url) {
            $('#modal-detail').modal('show');

            table1.ajax.url(url);
            table1.ajax.reload();
        }

        function deleteData(url) {
            if (bootbox.confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        bootbox.alert('Berhasil menghapus data');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        bootbox.alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }

        $('#export').on('click', function(e) {
            e.preventDefault();

            let tanggal_awal = $('#tanggal_awal').val() || localStorage.getItem('tanggal_awal');
            let tanggal_akhir = $('#tanggal_akhir').val() || localStorage.getItem('tanggal_akhir');

            if (!tanggal_awal || !tanggal_akhir) {
                window.location.href = '<?= route('penjualan.export') ?>';
            }

            let url = `{{ route('penjualan.export') }}?tanggal_awal=${tanggal_awal}&tanggal_akhir=${tanggal_akhir}`;
            window.location.href = url;
        });

        $('#exportPdfBtn').on('click', function(e) {
            e.preventDefault();

            let tanggal_awal = $('#tanggal_awal').val() || localStorage.getItem('tanggal_awal');
            let tanggal_akhir = $('#tanggal_akhir').val() || localStorage.getItem('tanggal_akhir');

            if (!tanggal_awal || !tanggal_akhir) {
                window.location.href = '<?= route('penjualan.exportpdf') ?>';
            }

            let url = `{{ route('penjualan.exportpdf') }}?tanggal_awal=${tanggal_awal}&tanggal_akhir=${tanggal_akhir}`;
            window.location.href = url;
        });


        function filter() {
            $.ajax({
                url: '{{ route('penjualan.filter') }}',
                success: function(response) {
                    bootbox.dialog({
                        title: 'Periode Laporan',
                        message: response,
                    })
                }
            })
        }

        function applyFilter() {
            localStorage.setItem('tanggal_awal', $('#tanggal_awal').val());
            localStorage.setItem('tanggal_akhir', $('#tanggal_akhir').val());

            bootbox.hideAll();
            table.ajax.reload();
        }

        $(document).on('shown.bs.modal', function() {
            if (localStorage.getItem('tanggal_awal')) {
                $('#tanggal_awal').val(localStorage.getItem('tanggal_awal'));
            }
            if (localStorage.getItem('tanggal_akhir')) {
                $('#tanggal_akhir').val(localStorage.getItem('tanggal_akhir'));
            }
        });
    </script>
@endpush
