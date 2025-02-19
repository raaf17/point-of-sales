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
                <td>
                    @if (\Carbon\Carbon::parse($stok->tgl_kadaluarsa)->lt(\Carbon\Carbon::today()))
                        <span class="badge bg-danger">Produk Kadaluarsa</span>
                    @elseif (\Carbon\Carbon::parse($stok->tgl_kadaluarsa)->diffInDays(\Carbon\Carbon::today()) < 7)
                        {{ \Carbon\Carbon::parse($stok->tgl_kadaluarsa)->format('d M Y') . ' (Hampir Kadaluarsa)' }}
                    @else
                        {{ \Carbon\Carbon::parse($stok->tgl_kadaluarsa)->format('d M Y') }}
                    @endif
                </td>
                <td>{{ $stok->stok }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
