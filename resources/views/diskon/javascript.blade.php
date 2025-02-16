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
                        data: 'tipe_member_id'
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
                error: function(error) {
                    var response = JSON.parse(error.responseText);
                    $('#formCreate').prepend(validation(response))
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
