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
                columns: [{
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

        // $(document).on('click', '.add-stok-btn', function(e) {
        //     e.preventDefault();
        //     var id = $(this).data('id');
        //     console.log(id)

        //     $.ajax({
        //         url: '{{ route('produk.addqty') }}',
        //         success: function(response) {
        //             bootbox.dialog({
        //                 title: 'Tambah Stok Produk',
        //                 message: response,
        //             })
        //         }
        //     })
        // });

        function addQty(id) {
            $.ajax({
                url: '{{ route('produk.addqty') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Tambah Stok Produk',
                        message: response,
                    })
                }
            })
        }

        function storeQty(id) {
            $.ajax({
                url: '{{ route('produk.storeqty') }}/' + id,
                type: 'POST',
                dataType: 'JSON',
                data: $('#formAddStok').serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success('Success', response.message);
                        table.ajax.reload();
                    } else {
                        toastr.error('Failed', response.message);
                    }
                    bootbox.hideAll();
                },
                error: function(xhr) {
                    if (xhr.status === 400) {
                        let response = xhr.responseJSON.errors;
                        $('.text-danger').text('');
                        if (response.stok) {
                            $('.error_stok').text(response.stok[0]);
                        }
                        if (response.tgl_pembelian) {
                            $('.error_tgl_pembelian').text(response.tgl_pembelian[0]);
                        }
                        if (response.tgl_kadaluarsa) {
                            $('.error_tgl_kadaluarsa').text(response.tgl_kadaluarsa[0]);
                        }
                    }
                }
            })
        }

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
                error: function(xhr) {
                    if (xhr.status === 400) {
                        let response = xhr.responseJSON.errors;
                        $('.text-danger').text('');
                        if (response.nama_produk) {
                            $('.error_nama_produk').text(response.nama_produk[0]);
                        }
                        if (response.id_kategori) {
                            $('.error_id_kategori').text(response.id_kategori[0]);
                        }
                        if (response.harga_beli) {
                            $('.error_harga_beli').text(response.harga_beli[0]);
                        }
                        if (response.satuan) {
                            $('.error_satuan').text(response.satuan[0]);
                        }
                        if (response.minimal_stok) {
                            $('.error_minimal_stok').text(response.minimal_stok[0]);
                        }
                    }
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
                error: function(xhr) {
                    if (xhr.status === 400) {
                        let response = xhr.responseJSON.errors;
                        $('.text-danger').text('');
                        if (response.nama_produk) {
                            $('.error_nama_produk').text(response.nama_produk[0]);
                        }
                        if (response.id_kategori) {
                            $('.error_id_kategori').text(response.id_kategori[0]);
                        }
                        if (response.harga_beli) {
                            $('.error_harga_beli').text(response.harga_beli[0]);
                        }
                        if (response.satuan) {
                            $('.error_satuan').text(response.satuan[0]);
                        }
                        if (response.minimal_stok) {
                            $('.error_minimal_stok').text(response.minimal_stok[0]);
                        }
                    }
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
    </script>
@endpush
