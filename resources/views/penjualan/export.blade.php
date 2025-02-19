<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #5a8ed1;
            color: white;
        }
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="title">DATA PENJUALAN</div>
    <div class="subtitle">Kasirku | Tanggal: {{ date('d-m-Y - H:i') }} | Pengunduh: {{ auth()->user()->name }}</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kasir</th>
                <th>Waktu & Tanggal Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Tipe Pelanggan</th>
                <th>Total Pembelanjaan</th>
                <th>Diskon (Rp.)</th>
                <th>Poin Digunakan</th>
                <th>Total Akhir</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($penjualan as $value)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ auth()->user()->name }}</td>
                    <td>{{ tanggal_indonesia($value->created_at) }}</td>
                    <td>{{ $value->id_member ? \App\Models\Member::where('id_member', $value->id_member)->value('nama') ?? 'Umum' : 'Umum' }}</td>
                    <td>{{ $value->id_member ? \App\Models\Member::where('id_member', $value->id_member)->value('tipe_member') ?? '-' : '-' }}</td>
                    <td>Rp. {{ format_uang($value->total_harga) }}</td>
                    <td>{{ $value->diskon }}%</td>
                    <td>{{ $value->id_member ? \App\Models\Member::where('id_member', $value->id_member)->value('poin') ?? '-' : '-' }}</td>
                    <td>Rp. {{ format_uang($value->bayar) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="8">Total Pendapatan</td>
                <td>Rp. {{ format_uang($totalPendapatan) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
