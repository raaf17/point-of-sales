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
                    // setTimeout(() => {
                    //     $('#diterima').trigger('input');
                    // }, 300);
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
            loadForm();
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

        function loadForm(diterima = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/transaksi/loadform') }}/${$('.total').text()}/${diterima}`)
                .done(response => {
                    let totalRp = parseFloat(response.totalrp) || 0;
                    let bayar = parseFloat(response.bayar) || 0;
                    let diskonPersen = parseFloat($('#diskon').val()) || 0;
                    let diskon = (bayar * diskonPersen) / 100;
                    let ppn = (bayar * 12) / 100;
                    let poin = $('#poin_check').is(':checked') ? parseFloat($('#poin').text()) || 0 : 0;

                    $('#nama').text($('#kode_member').val());
                    $('#poin').text($('#poin').val());
                    $('#poin_didapat').val(totalRp * 0.02);
                    $('#poin_digunakan').val(poin);
                    $('#ppn').val(formatRupiah(ppn));
                    $('#diskon').val(formatRupiah(diskon));
                    $('#totalrp').val(formatRupiah(totalRp));

                    let bayarRp = totalRp - poin - diskon + ppn;
                    $('#bayarrp').val(formatRupiah(bayarRp));
                    $('#bayar').val(bayar);
                    $('.tampil-bayar').text('Bayar: Rp. ' + formatRupiah(bayar));

                    $('#kembali').val('Rp.' + response.kembalirp);
                    if ($('#diterima').val() != 0) {
                        let kembaliRp = parseFloat($('#diterima').val()) - bayar;
                        $('#kembalirp').text(formatRupiah(kembaliRp));
                        $('.tampil-bayar').text('Kembali: Rp. ' + formatRupiah(kembaliRp));
                    }
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                });
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'decimal',
                minimumFractionDigits: 0
            }).format(angka);
        }

        $(document).ready(function() {
            $('#poin_check').on('change', function() {
                let poin = $('#poin_check').is(':checked') ? parseFloat($('#poin').text()) || 0 : 0;
                $('#poin_digunakan').val(poin);
            });
        });

        // function loadForm(diterima = 0) {
        //     $('#total').val($('.total').text());
        //     $('#total_item').val($('.total_item').text());

        //     $.get(`{{ url('/transaksi/loadform') }}/${$('.total').text()}/${diterima}`)
        //         .done(response => {
        //             $('#nama').text($('#kode_member').val());
        //             $('#poin').text($('#poin').val());
        //             $('#poin_didapat').val(response.totalrp * 0.02);
        //             $('#poin_digunakan').val($('#poin_check').is(':checked') ? $('#poin').text() : 0);
        //             $('#ppn').val(formatRupiah(response.bayar * 12 / 100));
        //             $('#diskon').val(formatRupiah(response.bayar * $('#diskon').val() / 100));
        //             $('#totalrp').val(formatRupiah(response.totalrp));
        //             $('#bayarrp').val(response.totalrp - $('#poin_digunakan').val() - (response.bayar * $('#diskon')
        //                 .val() / 100) + (response.bayar * 12 / 100));
        //             $('#bayar').val(response.bayar);
        //             $('.tampil-bayar').text('Bayar: ' + 'Rp. ' + formatRupiah(response.bayar));

        //             $('#kembali').val('Rp.' + response.kembalirp);
        //             if ($('#diterima').val() != 0) {
        //                 $('#kembalirp').text(formatRupiah($('#diterima').val() - response.bayar));
        //                 $('.tampil-bayar').text('Kembali: ' + 'Rp. ' + formatRupiah($('#diterima').val() - response
        //                     .bayar));
        //             }
        //         })
        //         .fail(errors => {
        //             alert('Tidak dapat menampilkan data');
        //             return;
        //         })
        // }

        // function formatRupiah(angka) {
        //     return new Intl.NumberFormat('id-ID', {
        //         style: 'decimal',
        //         minimumFractionDigits: 0
        //     }).format(angka);
        // }

        // $(document).ready(function() {
        //     $('#poin_check').on('change', function() {
        //         let poin = $('#poin_check').is(':checked') ? $('#poin').text() : 0;
        //         $('#poin_digunakan').val(poin);
        //         loadForm();
        //     });
        // });
    </script>
@endpush
