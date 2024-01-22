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
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">LAPORAN REKAP SALDO ANGGOTA</th>
        </tr>
        <tr>
            <th colspan="8">&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Keterangan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Jumlah Anggota</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="3">Saldo Simpanan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="3">Saldo Pembiayaan</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Wajib</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Sukarela</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Margin</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Minggon</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Keterangan</th>
            <th>Jumlah Anggota</th>
            <th>Simpanan Pokok</th>
            <th>Simpanan Wajib</th>
            <th>Simpanan Sukarela</th>
            <th>Saldo Pokok</th>
            <th>Saldo Margin</th>
            <th>Saldo Minggon</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($saldoanggota as $saldo)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->keterangan }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $saldo->jumlah_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->simwa }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->simpok }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->simsuk }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_pokok }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_margin }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_catab }}</td>
        </tr>
        @endforeach
        <tr>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;" colspan="2">TOTAL</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $total_anggota }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_simwa }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_simpok }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_simsuk }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_pokok }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_margin }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_catab }}</td>
        </tr>
    </tbody>
</table>