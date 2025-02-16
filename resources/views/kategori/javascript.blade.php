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
