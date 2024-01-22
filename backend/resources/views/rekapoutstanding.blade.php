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
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">LAPORAN REKAP OUTSTANDING</th>
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
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Keterangan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Jumlah</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Saldo Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Saldo Margin</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Saldo Catab</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="2">Persentase</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jumlah (%)</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Pokok (%)</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th>Saldo Pokok</th>
            <th>Saldo Margin</th>
            <th>Saldo Catab</th>
            <th>Persentase Jumlah</th>
            <th>Persentase Saldo Pokok</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($outstanding as $outs)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $outs->keterangan }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $outs->jumlah_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $outs->saldo_pokok }}</td>
            <td style="border: 1px solid #000;">{{ $outs->saldo_margin }}</td>
            <td style="border: 1px solid #000;">{{ $outs->saldo_catab }}</td>
            <td style="border: 1px solid #000;">{{ $outs->persen_jumlah }}</td>
            <td style="border: 1px solid #000;">{{ $outs->persen_nominal }}</td>
        </tr>
        @endforeach
        <tr>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;" colspan="2">TOTAL</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $total_anggota }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_pokok }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_margin }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_catab }}</td>
        </tr>
    </tbody>
</table>