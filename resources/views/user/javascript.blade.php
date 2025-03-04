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
                    url: '{{ route('user.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'level'
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
                url: '{{ route('user.create') }}',
                success: function(response) {
                    bootbox.dialog({
                        title: 'Tambah User',
                        message: response,
                    })
                }
            })
        }

        function store() {
            $.ajax({
                url: '{{ route('user.store') }}',
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
                        if (response.name) {
                            $('.error_name').text(response.name[0]);
                        }
                        if (response.email) {
                            $('.error_email').text(response.email[0]);
                        }
                        if (response.password) {
                            $('.error_password').text(response.password[0]);
                        }
                    }
                }
            })
        }

        function view(id) {
            $.ajax({
                url: '{{ route('user.view') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Detail User',
                        message: response,
                    })
                }
            })
        }

        function edit(id) {
            $.ajax({
                url: '{{ route('user.edit') }}/' + id,
                success: function(response) {
                    bootbox.dialog({
                        title: 'Edit User',
                        message: response,
                    })
                }
            })
        }

        function update(id) {
            $.ajax({
                url: '{{ route('user.update') }}/' + id,
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
                        if (response.name) {
                            $('.error_name').text(response.name[0]);
                        }
                        if (response.email) {
                            $('.error_email').text(response.email[0]);
                        }
                        if (response.password) {
                            $('.error_password').text(response.password[0]);
                        }
                    }
                }
            })
        }

        function destroy(id) {
            bootbox.confirm("Apakah anda yakin ingin menghapus data ini?", function(result) {
                if (result) {
                    $.ajax({
                        url: '{{ route('user.delete') }}/' + id,
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Success', response.message);
                                table.ajax.reload();
                            } else {
                                toastr.error('Failed', response.message);
                            }
                        },
                        error: function(response) {
                            toastr.error('Failed', 'User ini sedang digunakan');
                        },
                    })
                }
            });
        }
    </script>
@endpush
