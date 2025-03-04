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
                    url: '{{ route('diskon.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_diskon'
                    },
                    {
                        data: 'nama_diskon'
                    },
                    {
                        data: 'diskon'
                    },
                    {
                        data: 'waktu'
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
                url: '{{ route('diskon.create') }}',
                success: function(response) {
                    bootbox.dialog({
                        title: 'Tambah Diskon',
                        message: response,
                    })
                }
            })
        }

        function store() {
            $.ajax({
                url: '{{ route('diskon.store') }}',
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
                        if (response.nama_diskon) {
                            $('.error_nama_diskon').text(response.nama_diskon[0]);
                        }
                        if (response.min_diskon) {
                            $('.error_min_diskon').text(response.min_diskon[0]);
                        }
                        if (response.max_diskon) {
                            $('.error_max_diskon').text(response.max_diskon[0]);
                        }
                        if (response.diskon) {
                            $('.error_diskon').text(response.diskon[0]);
                        }
                        if (response.tgl_mulai) {
                            $('.error_tgl_mulai').text(response.tgl_mulai[0]);
                        }
                        if (response.tgl_berakhir) {
                            $('.error_tgl_berakhir').text(response.tgl_berakhir[0]);
                        }
                    }
                }
            })
        }

        function view(id) {
            $.ajax({
                url: '{{ route('diskon.view') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Detail Diskon',
                        message: response,
                    })
                }
            })
        }

        function edit(id) {
            $.ajax({
                url: '{{ route('diskon.edit') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Edit Diskon',
                        message: response,
                    })
                }
            })
        }

        function update(id) {
            $.ajax({
                url: '{{ route('diskon.update') }}/' + id,
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
                        if (response.nama_diskon) {
                            $('.error_nama_diskon').text(response.nama_diskon[0]);
                        }
                        if (response.min_diskon) {
                            $('.error_min_diskon').text(response.min_diskon[0]);
                        }
                        if (response.max_diskon) {
                            $('.error_max_diskon').text(response.max_diskon[0]);
                        }
                        if (response.diskon) {
                            $('.error_diskon').text(response.diskon[0]);
                        }
                        if (response.tgl_mulai) {
                            $('.error_tgl_mulai').text(response.tgl_mulai[0]);
                        }
                        if (response.tgl_berakhir) {
                            $('.error_tgl_berakhir').text(response.tgl_berakhir[0]);
                        }
                    }
                }
            })
        }

        function destroy(id) {
            bootbox.confirm("Apakah anda yakin ingin menghapus data ini?", function(result) {
                if (result) {
                    $.ajax({
                        url: '{{ route('diskon.delete') }}/' + id,
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Success', response.message);
                                table.ajax.reload();
                            } else {
                                toastr.error('Failed', response.message);
                            }
                        },
                        error: function(response) {
                            toastr.error('Failed', 'Diskon ini sedang digunakan');
                        },
                    })
                }
            });
        }
    </script>
@endpush
