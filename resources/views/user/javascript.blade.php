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
                error: function(error) {
                    var response = JSON.parse(error.responseText);
                    $('#formCreate').prepend(validation(response))
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
