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
                    url: '{{ route('produk.data') }}',
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'nama_kategori'
                    },
                    {
                        data: 'stok'
                    },
                    {
                        data: 'satuan'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'harga_jual_1'
                    },
                    {
                        data: 'harga_jual_2'
                    },
                    {
                        data: 'harga_jual_3'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });
        });

        function create() {
            $.ajax({
                url: '{{ route('produk.create') }}',
                success: function(response) {
                    bootbox.dialog({
                        title: 'Tambah Produk',
                        message: response,
                    })
                }
            })
        }

        function store() {
            $.ajax({
                url: '{{ route('produk.store') }}',
                type: 'POST',
                dataType: 'JSON',
                data: $('#formCreate').serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success('Success', response.message);
                        table.ajax.reload();
                    } else {
                        toastr.error('Failed', response.message);
                    }
                    bootbox.hideAll();
                },
                error: function(error) {
                    var response = JSON.parse(error.responseText);
                    $('#formCreate').prepend(validation(response))
                }
            })
        }

        function view(id) {
            $.ajax({
                url: '{{ route('produk.view') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Detail Produk',
                        message: response,
                    })
                }
            })
        }

        function edit(id) {
            $.ajax({
                url: '{{ route('produk.edit') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Edit Produk',
                        message: response,
                    })
                }
            })
        }

        function update(id) {
            $.ajax({
                url: '{{ route('produk.update') }}/' + id,
                type: 'POST',
                dataType: 'JSON',
                data: $('#formEdit').serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success('Success', response.message);
                        table.ajax.reload();
                    } else {
                        toastr.error('Failed', response.message);
                    }
                    bootbox.hideAll();
                },
                error: function(error) {
                    var response = JSON.parse(error.responseText);
                    $('#formEdit').prepend(validation(response))
                }
            })
        }

        function destroy(id) {
            bootbox.confirm("Apakah anda yakin ingin menghapus data ini?", function(result) {
                if (result) {
                    $.ajax({
                        url: '{{ route('produk.delete') }}/' + id,
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Success', response.message);
                                table.ajax.reload();
                            } else {
                                toastr.error('Failed', response.message);
                            }
                        },
                        error: function(response) {
                            toastr.error('Failed', 'Produk ini sedang digunakan');
                        },
                    })
                }
            });
        }

        // function cetakBarcode(url) {
        //     if ($('input:checked').length < 1) {
        //         alert('Pilih data yang akan dicetak');
        //         return;
        //     } else if ($('input:checked').length < 3) {
        //         alert('Pilih minimal 3 data untuk dicetak');
        //         return;
        //     } else {
        //         $('.form-produk')
        //             .attr('target', '_blank')
        //             .attr('action', url)
        //             .submit();
        //     }
        // }
    </script>
@endpush
