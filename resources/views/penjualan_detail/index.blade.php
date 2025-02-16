<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/css/main/app.css">
    <link rel="stylesheet" href="{{ asset('css') }}/app.css" />
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/css/pages/fontawesome.css">
    <link rel="stylesheet"
        href="{{ asset('mazer') }}/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/css/pages/datatables.css">
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/extensions/toastify-js/src/toastify.css" />
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/extensions/sweetalert2/sweetalert2.min.css" />
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/css/shared/iconly.css" />
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/compiled/css/app-dark.css">
    <style>
        .tampil-bayar {
            font-size: 4.1em;
            text-align: center;
            height: 100px;
            width: 707px;
            border-radius: 5px;
            margin-top: 20px;
            margin-left: 10px
        }

        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
        }

        .table-penjualan tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }
    </style>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <div class="d-block">
                            <a href="{{ route('dashboard') }}" class="fs-3 text-gray font-bold">Kasirku</a>
                        </div>
                        <div class="header-top-right">
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">{{ auth()->user()->name }}</h6>
                                            <p class="mb-0 text-sm text-gray-600">Administrator</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="{{ url(auth()->user()->foto ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                    style="min-width: 11rem;">
                                    <li>
                                        <h6 class="dropdown-header">Hello, {{ auth()->user()->name }}!</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('user.profil') }}"><i
                                                class="icon-mid bi bi-person me-2"></i> My
                                            Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        <li>
                                            @csrf
                                            <a class="dropdown-item" href="#"
                                                onclick="$('#logout-form').submit()">
                                                <i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a>
                                        </li>
                                    </form>
                                </ul>
                            </div>

                            <a href="#" class="burger-btn d-block d-xl-none">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-wrapper container">
                <div class="page-content" style="margin-top: -20px">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label for="kode_member">Member</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="kode_member"
                                                        value="{{ $memberSelected->kode_member }}">
                                                    <span class="input-group-btn">
                                                        <button onclick="tampilMember()" class="btn btn-info btn-flat"
                                                            type="button"><i class="fa fa-arrow-right"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <form class="form-produk">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="kode_produk">Kode Produk</label>
                                                    <div class="input-group">
                                                        <input type="hidden" name="id_penjualan" id="id_penjualan"
                                                            value="{{ $id_penjualan }}">
                                                        <input type="hidden" name="id_produk" id="id_produk">
                                                        <input type="text" class="form-control" name="kode_produk"
                                                            id="kode_produk">
                                                        <span class="input-group-btn">
                                                            <button onclick="tampilProduk()"
                                                                class="btn btn-info btn-flat" type="button"><i
                                                                    class="fa fa-arrow-right"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table table-stiped table-bordered table-penjualan">
                                            <thead>
                                                <th width="5%">No.</th>
                                                <th width="10%">Kode</th>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th width="8%">Jumlah</th>
                                                <th width="8%">Diskon</th>
                                                <th>Subtotal</th>
                                                <th width="3%"><i class="fa fa-cog"></i></th>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="tampil-bayar bg-primary text-white"></div>
                                        {{-- <div class="tampil-terbilang"></div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">Ringkasan Belanja</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('transaksi.simpan') }}" class="form-penjualan"
                                        method="post">
                                        @csrf
                                        <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                                        <input type="hidden" name="total" id="total">
                                        <input type="hidden" name="total_item" id="total_item">
                                        <input type="hidden" name="bayar" id="bayar">
                                        <input type="hidden" name="id_member" id="id_member"
                                            value="{{ $memberSelected->id_member }}">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="totalrp">Poin Didapatkan</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp.</span>
                                                        <input type="text" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="totalrp">Poin Digunakan</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp.</span>
                                                        <input type="text" id="totalrp" class="form-control"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="totalrp">Total Harga</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp.</span>
                                                        <input type="text" id="totalrp" class="form-control"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="totalrp">Diskon</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp.</span>
                                                        <input type="number" name="diskon" id="diskon"
                                                            class="form-control"
                                                            value="{{ !empty($memberSelected->id_member) ? $diskon : 0 }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="totalrp">PPN 12%</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp.</span>
                                                        <input type="text" id="totalrp" class="form-control"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="bayarrp" class="fs-5">Total Akhir</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" id="bayarrp" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="totalrp">Diterima</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="number" id="diterima" class="form-control"
                                                    name="diterima" value="{{ $penjualan->diterima ?? 0 }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="alert alert-light-primary" style="margin-left: 11px; width: 486px;">
                                                <h6 class="py-1" style="margin-bottom: -0px;">Kembalian : Rp.</h6>
                                                {{-- <p>This is a primary alert.</p> --}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary btn-block btn-simpan"><i
                                                        class="fa fa-check"></i>
                                                    Simpan</button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-secondary btn-block btn-simpan">
                                                    Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                {{-- <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-flat pull-right btn-simpan"><i
                                            class="fa fa-check"></i>
                                        Simpan Transaksi</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    @includeIf('penjualan_detail.produk')
                    @includeIf('penjualan_detail.member')
                </div>
            </div>
            <footer>
                <div class="container">
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>Copyright &copy; {{ date('Y') }}</p>
                        </div>
                        <div class="float-end">
                            <p>Kasirku</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('mazer') }}/assets/js/bootstrap.js"></script>
    <script src="{{ asset('mazer') }}/assets/js/app.js"></script>

    <script src="{{ asset('mazer') }}/assets/extensions/jquery/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('mazer') }}/assets/js/pages/datatables.js"></script>
    <script src="{{ asset('mazer') }}/assets/extensions/toastify-js/src/toastify.js"></script>
    <script src="{{ asset('mazer') }}/assets/js/pages/toastify.js"></script>

    <script src="{{ asset('mazer') }}/assets/extensions/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('mazer') }}/assets/static/js/components/dark.js"></script>
    <script>
        let table, table2;

        $(function() {
            $('body').addClass('sidebar-collapse');

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
                    loadForm($('#diskon').val());
                    setTimeout(() => {
                        $('#diterima').trigger('input');
                    }, 300);
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
                            table.ajax.reload(() => loadForm($('#diskon').val()));
                        });
                    })
                    .fail(errors => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            });

            $(document).on('input', '#diskon', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($(this).val());
            });

            $('#diterima').on('input', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($('#diskon').val(), $(this).val());
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
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        }

        function tampilMember() {
            $('#modal-member').modal('show');
        }

        function pilihMember(id, kode) {
            $('#id_member').val(id);
            $('#kode_member').val(kode);
            $('#diskon').val('{{ $diskon }}');
            loadForm($('#diskon').val());
            $('#diterima').val(0).focus().select();
            hideMember();
        }

        function hideMember() {
            $('#modal-member').modal('hide');
        }

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }

        function loadForm(diskon = 0, diterima = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
                .done(response => {
                    $('#totalrp').val('Rp. ' + response.totalrp);
                    $('#bayarrp').val(response.bayar);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Bayar: ' + formatRupiah(response.bayar));
                    $('.tampil-terbilang').text(response.terbilang);

                    $('#kembali').val('Rp.' + response.kembalirp);
                    if ($('#diterima').val() != 0) {
                        $('.tampil-bayar').text('Kembali: ' + formatRupiah(response.kembalirp));
                        $('.tampil-terbilang').text(response.kembali_terbilang);
                    }
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }
    </script>
</body>

</html>
