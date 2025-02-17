@extends('layouts.kasir')

@section('content')
    <div class="row">
        @include('penjualan_detail.form_input')
        @include('penjualan_detail.form_summary')
    </div>
    @includeIf('penjualan_detail.produk')
    @includeIf('penjualan_detail.member')
    @includeIf('penjualan_detail.diskon')
@endsection
@push('scripts')
    <script>
        let table, table2;

        $(function() {
            table = $('.table-penjualan').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: {
                        url: '{{ route('transaksi.data', $id_penjualan) }}',
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
                            data: 'harga_jual'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'diskon'
                        },
                        {
                            data: 'subtotal'
                        },
                        {
                            data: 'aksi',
                            searchable: false,
                            sortable: false
                        },
                    ],
                    dom: 'Brt',
                    bSort: false,
                    paginate: false
                })
                .on('draw.dt', function() {
                    loadForm();
                    setTimeout(() => {
                        $('#diterima').trigger('input');
                    }, 300);
                });
            table2 = $('.table-produk').DataTable();

            $(document).on('input', '.quantity', function() {
                let id = $(this).data('id');
                let jumlah = parseInt($(this).val());

                if (jumlah < 1) {
                    $(this).val(1);
                    alert('Jumlah tidak boleh kurang dari 1');
                    return;
                }
                if (jumlah > 10000) {
                    $(this).val(10000);
                    alert('Jumlah tidak boleh lebih dari 10000');
                    return;
                }

                $.post(`{{ url('/transaksi') }}/${id}`, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'put',
                        'jumlah': jumlah
                    })
                    .done(response => {
                        $(this).on('mouseout', function() {
                            table.ajax.reload(() => loadForm());
                        });
                    })
                    .fail(errors => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            });

            $('#diterima').on('input', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($(this).val());
            }).focus(function() {
                $(this).select();
            });

            $('.btn-simpan').on('click', function() {
                $('.form-penjualan').submit();
            });
        });

        function tampilProduk() {
            $('#modal-produk').modal('show');
        }

        function hideProduk() {
            $('#modal-produk').modal('hide');
        }

        function pilihProduk(id, kode) {
            $('#id_produk').val(id);
            $('#kode_produk').val(kode);
            hideProduk();
            tambahProduk();
        }

        function tambahProduk() {
            $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
                .done(response => {
                    $('#kode_produk').focus();
                    table.ajax.reload(() => loadForm());
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        }

        function tampilMember() {
            $('#modal-member').modal('show');
        }

        function tampilDiskon() {
            $('#modal-diskon').modal('show');
        }

        function pilihMember(id, kode, poin) {
            $('#id_member').val(id);
            $('#kode_member').val(kode);
            $('#poin').val(poin);
            // $('#poin').text(poin[0]?.textContent || 'Data tidak ditemukan');
            loadForm();
            $('#diterima').val(0).focus().select();
            hideMember();
        }

        function pilihDiskon(id, kode, diskon) {
            $('#id_diskon').val(id);
            $('#kode_diskon').val(kode);
            $('#diskon').val(diskon);
            loadForm();
            hideDiskon();
        }

        function hideMember() {
            $('#modal-member').modal('hide');
        }

        function hideDiskon() {
            $('#modal-diskon').modal('hide');
        }

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload(() => loadForm());
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }

        function loadForm(diskon = 0, diterima = 0, $poin = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
                .done(response => {
                    $('#nama').text($('#kode_member').val());
                    $('#poin').text($('#poin').val());
                    $('#poin_didapat').val(response.totalrp * 0.02);
                    $('#poin_digunakan').val($('#poin_check').is(':checked') ? $('#poin').text() : 0);
                    $('#ppn').val(formatRupiah(response.bayar * 12 / 100));
                    $('#diskon').val(formatRupiah(response.bayar * $('#diskon').val() / 100));
                    $('#totalrp').val(formatRupiah(response.totalrp));
                    $('#bayarrp').val(response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Bayar: ' + 'Rp. ' + formatRupiah(response.bayar));
                    $('.tampil-terbilang').text(response.terbilang);

                    $('#kembali').val('Rp.' + response.kembalirp);
                    if ($('#diterima').val() != 0) {
                        $('#kembalirp').text($('#diterima').val() - response.bayar);
                        $('.tampil-bayar').text('Kembali: ' + 'Rp. ' + formatRupiah(response.kembali));
                        $('.tampil-terbilang').text(response.kembali_terbilang);
                    }
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'decimal',
                minimumFractionDigits: 0
            }).format(angka);
        }

        $(document).ready(function() {
            $('#poin_check').on('change', function() {
                let poin = $('#poin_check').is(':checked') ? $('#poin').text() : 0;
                $('#poin_digunakan').val(poin);
            });
        });
    </script>
@endpush
