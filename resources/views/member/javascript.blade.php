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
                    url: '{{ route('member.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_member'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'telepon'
                    },
                    {
                        data: 'alamat'
                    },
                    {
                        data: 'tipe_member'
                    },
                    {
                        data: 'poin'
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
                url: '{{ route('member.create') }}',
                success: function(response) {
                    bootbox.dialog({
                        title: 'Tambah Member',
                        message: response,
                    })
                }
            })
        }

        function store() {
            $.ajax({
                url: '{{ route('member.store') }}',
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
                        if (response.nama) {
                            $('.error_nama').text(response.nama[0]);
                        }
                        if (response.telepon) {
                            $('.error_telepon').text(response.telepon[0]);
                        }
                        if (response.alamat) {
                            $('.error_alamat').text(response.alamat[0]);
                        }
                        if (response.tipe_member) {
                            $('.error_tipe_member').text(response.tipe_member[0]);
                        }
                    }
                }
            })
        }

        function view(id) {
            $.ajax({
                url: '{{ route('member.view') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Detail Member',
                        message: response,
                    })
                }
            })
        }

        function edit(id) {
            $.ajax({
                url: '{{ route('member.edit') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Edit Member',
                        message: response,
                    })
                }
            })
        }

        function update(id) {
            $.ajax({
                url: '{{ route('member.update') }}/' + id,
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
                        if (response.nama) {
                            $('.error_nama').text(response.nama[0]);
                        }
                        if (response.telepon) {
                            $('.error_telepon').text(response.telepon[0]);
                        }
                        if (response.alamat) {
                            $('.error_alamat').text(response.alamat[0]);
                        }
                        if (response.tipe_member) {
                            $('.error_tipe_member').text(response.tipe_member[0]);
                        }
                    }
                }
            })
        }

        function destroy(id) {
            bootbox.confirm("Apakah anda yakin ingin menghapus data ini?", function(result) {
                if (result) {
                    $.ajax({
                        url: '{{ route('member.delete') }}/' + id,
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Success', response.message);
                                table.ajax.reload();
                            } else {
                                toastr.error('Failed', response.message);
                            }
                        },
                        error: function(response) {
                            toastr.error('Failed', 'Member ini sedang digunakan');
                        },
                    })
                }
            });
        }
    </script>
@endpush
