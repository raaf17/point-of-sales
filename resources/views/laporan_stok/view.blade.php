<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal Kadaluarsa</th>
            <th>Jumlah Stok</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produk->stok as $stok)
        <tr>
            <td>{{ \Carbon\Carbon::parse($stok->tgl_kadaluarsa)->format('d M Y') }}</td>
            <td>{{ $stok->stok }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
