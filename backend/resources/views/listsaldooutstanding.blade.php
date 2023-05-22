<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="12">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="12">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="12">LAPORAN LIST SALDO OUTSTANDING</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Kantor</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Majelis</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">No. Rekening</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Tgl. Cair</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Produk</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Margin</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Jangka Waktu</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="2">Saldo</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Margin</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>Nama</th>
            <th>Majelis</th>
            <th>No. Rekening</th>
            <th>Tgl. Cair</th>
            <th>Produk</th>
            <th>Pokok</th>
            <th>Margin</th>
            <th>Jangka Waktu</th>
            <th>Saldo Pokok</th>
            <th>Saldo Margin</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($saldooutstanding as $saldo)

        @if($saldo->periode_jangka_waktu == 0)
        {{ $periode = 'Harian' }}
        @elseif($saldo->periode_jangka_waktu == 1)
        {{ $periode = 'Mingguan' }}
        @elseif($saldo->periode_jangka_waktu == 2)
        {{ $periode = 'Bulanan' }}
        @else
        {{ $periode = 'Tempo' }}
        @endif
        <tr>
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_cabang }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_rembug }}</td>
            <td style="border: 1px solid #000;">'{{ $saldo->no_rekening }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->tanggal_akad }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_produk }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->pokok }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->margin }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->jangka_waktu }} {{ $periode }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_pokok }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_margin }}</td>
        </tr>
        @endforeach
    </tbody>
</table>