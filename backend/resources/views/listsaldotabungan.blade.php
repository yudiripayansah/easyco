<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">{{ $produk }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">LAPORAN LIST SALDO TABUNGAN</th>
        </tr>
        <tr>
            <th colspan="26">&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No. Rekening</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Majelis</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Petugas</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">ID Anggota</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Produk</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>No. Rekening</th>
            <th>Majelis</th>
            <th>Petugas</th>
            <th>ID Anggota</th>
            <th>Nama</th>
            <th>Produk</th>
            <th>Saldo</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($saldotabungan as $tabungan)
        <tr>
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">'{{ $tabungan->no_rekening }}</td>
            <td style="border: 1px solid #000;">{{ $tabungan->nama_rembug }}</td>
            <td style="border: 1px solid #000;">{{ $tabungan->nama_petugas }}</td>
            <td style="border: 1px solid #000;">'{{ $tabungan->no_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $tabungan->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $tabungan->nama_produk }}</td>
            <td style="border: 1px solid #000;">{{ $tabungan->saldo }}</td>
        </tr>
        @endforeach
    </tbody>
</table>