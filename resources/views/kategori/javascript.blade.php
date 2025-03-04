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
                    url: '{{ route('kategori.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_kategori'
                    },
                    {
                        data: 'nama_kategori'
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
                url: '{{ route('kategori.create') }}',
                success: function(response) {
                    bootbox.dialog({
                        title: 'Tambah Kategori',
                        message: response,
                    })
                }
            })
        }

        function store() {
            $.ajax({
                url: '{{ route('kategori.store') }}',
                type: 'POST',
                dataType: 'JSON',
                data: $('#formCreate').serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success('Success', response.message);
                        table.ajax.reload();
                        $('#formCreate')[0].reset();
                        bootbox.hideAll();
                    } else {
                        toastr.error('Failed', response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 400) {
                        let response = xhr.responseJSON.errors;
                        $('.text-danger').text('');
                        if (response.nama_kategori) {
                            $('.error_nama_kategori').text(response.nama_kategori[0]);
                        }
                        if (response.warna) {
                            $('.error_warna').text(response.warna[0]);
                        }
                    }
                }
            });
        }

        function view(id) {
            $.ajax({
                url: '{{ route('kategori.view') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Detail Kategori',
                        message: response,
                    })
                }
            })
        }

        function edit(id) {
            $.ajax({
                url: '{{ route('kategori.edit') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Edit Kategori',
                        message: response,
                    })
                }
            })
        }

        function update(id) {
            $.ajax({
                url: '{{ route('kategori.update') }}/' + id,
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
                        if (response.nama_kategori) {
                            $('.error_nama_kategori').text(response.nama_kategori[0]);
                        }
                        if (response.warna) {
                            $('.error_warna').text(response.warna[0]);
                        }
                    }
                }
            })
        }

        function destroy(id) {
            bootbox.confirm("Apakah anda yakin ingin menghapus data ini?", function(result) {
                if (result) {
                    $.ajax({
                        url: '{{ route('kategori.delete') }}/' + id,
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Success', response.message);
                                table.ajax.reload();
                            } else {
                                toastr.error('Failed', response.message);
                            }
                        },
                        error: function(response) {
                            toastr.error('Failed', 'Kategori ini sedang digunakan');
                        },
                    })
                }
            });
        }
    </script>
@endpush
