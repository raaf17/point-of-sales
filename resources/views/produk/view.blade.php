<table class="table" style="border: none">
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Kode Produk</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $produk->kode_produk }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Nama Produk</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $produk->nama_produk }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Kategori</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{!! $kategori !!}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Satuan</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $produk->satuan }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Harga Beli</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $produk->harga_beli }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Harga Jual 1</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $harga_jual_1 }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Harga Jual 2</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $harga_jual_2 }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Harga Jual 3</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $harga_jual_3 }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Stok</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $stok }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Minimal Stok</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $produk->minimal_stok }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Diskon</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $produk->diskon }}</td>
    </tr>
</table>
