<table class="table" style="border: none">
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Kode Diskon</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $diskon->kode_diskon }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Nama Diskon</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $diskon->nama_diskon }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Tipe Member</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $diskon->tipe_member_id }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Min. Diskon</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $diskon->min_diskon }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Max Diskon</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $diskon->max_diskon }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Diskon</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $diskon->diskon }}</td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;">Rentang Waktu</td>
        <td style="border-top: 0; border-bottom: 0;">:</td>
        <td style="border-top: 0; border-bottom: 0;">{{ $diskon->tgl_mulai . ' s/d ' . $diskon->tgl_berakhir }}</td>
    </tr>
</table>
