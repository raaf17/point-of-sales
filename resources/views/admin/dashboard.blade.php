@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon blue mb-2">
                                <i class="fa fa-folder-open fs-5"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Total Kategori</h6>
                            <h6 class="font-extrabold mb-0 fs-5">{{ $kategori }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon purple mb-2">
                                <i class="fa fa-archive fs-5"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Total Produk</h6>
                            <h6 class="font-extrabold mb-0 fs-5">{{ $produk }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon green mb-2">
                                <i class="fa fa-users fs-5"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Total Member</h6>
                            <h6 class="font-extrabold mb-0 fs-5">{{ $member }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon green mb-2">
                                <i class="fa fa-money-bill-wave fs-5"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Pendapatan</h6>
                            <h6 class="font-extrabold mb-0 fs-5">{{ number_format($pendapatan, 2, ',', '.') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h4>Hasil Pendapatan Minggu Terakhir</h4>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button class="btn btn-light icon" onclick="getData()"><i class="fas fa-sync-alt"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h4>Stok Menipis</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <th width="5%">No.</th>
                                <th>Nama Produk</th>
                                <th>Stok</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                searching: false,
                // info: false,
                lengthChange: false,
                pageLength: 5,
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('dashboard.data') }}',
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
                        data: 'stok'
                    },
                ]
            });
        })
        const ctx = document.getElementById('salesChart').getContext('2d');

        const salesData = {
            labels: {!! json_encode(array_keys($salesByDay)) !!}, // Days (e.g., Monday, Tuesday, etc.)
            datasets: [{
                label: 'Total Sales',
                data: {!! json_encode(array_values($salesByDay)) !!}, // Sales values
                borderColor: 'rgba(103,119,239,255)',
                backgroundColor: 'rgba(103,119,239,255)',
                borderWidth: 2,
                pointRadius: 5, // Dot size
                pointBackgroundColor: 'rgba(103,119,239,255)',
                pointBorderColor: 'white',
                pointBorderWidth: 2
            }]
        };

        function formatRupiah(value) {
            return 'Rp. ' + new Intl.NumberFormat('id-ID').format(value);
        }

        const salesChart = new Chart(ctx, {
            type: 'line',
            data: salesData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }, // Show legend
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItem) {
                                let value = tooltipItem.raw || 0;
                                return formatRupiah(value); // Apply currency format
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end', // Position on top of the dot
                        align: 'top',
                        color: 'black',
                        font: {
                            weight: 'bold',
                            size: 12
                        },
                        formatter: (value) => formatRupiah(value) // Apply currency format
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return formatRupiah(value); // Apply currency format to Y-axis
                            }
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Activate the plugin
        });
    </script>
@endpush
