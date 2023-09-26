<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="14">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="14">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="14">{{ $petugas }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="14">{{ $rembug }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="14">LAPORAN LIST PELUNASAN</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="14">PERIODE : {{ $from_date }} s.d {{ $thru_date }}</th>
        </tr>
        <tr>
            <th colspan="26">&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">NO</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">TANGGAL LUNAS</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="2">ANGGOTA</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">MAJELIS</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="2">JUMLAH</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">JANGKA WAKTU</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">JATUH TEMPO</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="3">SALDO HUTANG</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">CASH BACK</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">PETUGAS</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No. Rekening</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Margin</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Cnt</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Margin</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Tanggal Lunas</th>
            <th>No. Rekening</th>
            <th>Nama</th>
            <th>Majelis</th>
            <th>Pokok</th>
            <th>Margin</th>
            <th>Jangka Waktu</th>
            <th>Jatuh Tempo</th>
            <th>Terbayar</th>
            <th>Saldo Pokok</th>
            <th>Saldo Margin</th>
            <th>Cash Back</th>
            <th>Petugas</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($pelunasan as $lunas)
        <tr>
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->tanggal_pelunasan }}</td>
            <td style="border: 1px solid #000;">'{{ $lunas->no_rekening }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->nama_rembug }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->pokok }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->margin }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->jangka_waktu }} {{ $lunas->periode_jangka_waktu }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->tanggal_jtempo }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->counter_angsuran }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->saldo_pokok }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->saldo_margin }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->potongan_margin }}</td>
            <td style="border: 1px solid #000;">{{ $lunas->nama_pgw }}</td>
        </tr>
        @endforeach
    </tbody>
</table>