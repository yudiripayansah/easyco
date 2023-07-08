<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">{{ $head->nama_cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">LAPORAN BUKU BESAR</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th style="font-size: 11px;">Tanggal</th>
            <th style="font-size: 11px;">: {{ $head->from_date }} s.d {{ $head->thru_date }}</th>
            <th style="font-size: 11px;">&nbsp;</th>
            <th style="font-size: 11px;">&nbsp;</th>
            <th style="font-size: 11px;">&nbsp;</th>
            <th style="font-size: 11px;">&nbsp;</th>
        </tr>
        <tr>
            <th style="font-size: 11px;">Kode GL</th>
            <th style="font-size: 11px;">: {{ $head->kode_gl }}</th>
            <th style="font-size: 11px;">&nbsp;</th>
            <th style="font-size: 11px;">&nbsp;</th>
            <th style="font-size: 11px;">&nbsp;</th>
            <th style="font-size: 11px;">&nbsp;</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tgl. Transaksi</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Keterangan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Debet</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Credit</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Akhir</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Tgl. Transaksi</th>
            <th>Keterangan</th>
            <th>Debet</th>
            <th>Credit</th>
            <th>Saldo Akhir</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($bukubesar as $buku)
        <tr>
            <td style="border: 1px solid #000; vertical-align: middle; text-align: center;">{{ $no++ }}</td>
            <td style="border: 1px solid #000; vertical-align: middle; text-align: center;">{{ $buku['trx_date'] }}</td>
            <td style="border: 1px solid #000; vertical-align: middle; text-align: center;">{{ $buku['description'] }}</td>
            <td style="border: 1px solid #000; vertical-align: middle;">{{ $buku['debet'] }}</td>
            <td style="border: 1px solid #000; vertical-align: middle;">{{ $buku['credit'] }}</td>
            <td style="border: 1px solid #000; vertical-align: middle;">{{ $buku['saldo_akhir'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>