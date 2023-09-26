<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="9">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="9">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="9">{{ $produk }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="9">{{ $from_date }} s.d {{ $thru_date }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="9">LAPORAN LIST BUKA TABUNGAN</th>
        </tr>
        <tr>
            <th colspan="26">&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Kantor</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tgl. Buka</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No. Rekening</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Produk</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jangka Waktu</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>Tgl. Buka</th>
            <th>No. Rekening</th>
            <th>Nama</th>
            <th>Produk</th>
            <th>Jangka Waktu</th>
            <th>Saldo</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($bukatabungan as $buka)
        <tr>
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $buka->nama_cabang }}</td>
            <td style="border: 1px solid #000;">{{ $buka->tanggal_buka }}</td>
            <td style="border: 1px solid #000;">{{ $buka->no_rekening }}</td>
            <td style="border: 1px solid #000;">{{ $buka->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $buka->nama_produk }}</td>
            <td style="border: 1px solid #000;">{{ $buka->jangka_waktu }} {{ $buka->periode }}</td>
            <td style="border: 1px solid #000;">{{ $buka->saldo }}</td>
        </tr>
        @endforeach
    </tbody>
</table>