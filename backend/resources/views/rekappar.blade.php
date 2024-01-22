<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="17">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="17">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="17">LAPORAN REKAP KOLEKTIBILITAS</th>
        </tr>
        <tr>
            <th colspan="17">&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Kantor</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="3">PAR (1 - 30)</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="3">PAR (31 - 60)</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="3">PAR (61 - 90)</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="3">PAR (91 - 120)</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="3">PAR (> 120)</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jml</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">CPP</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jml</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">CPP</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jml</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">CPP</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jml</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">CPP</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jml</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">CPP</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>PAR (1 - 30) - Jml</th>
            <th>PAR (1 - 30) - Saldo Pokok</th>
            <th>PAR (1 - 30) - CPP</th>
            <th>PAR (31 - 60) - Jml</th>
            <th>PAR (31 - 60) - Saldo Pokok</th>
            <th>PAR (31 - 60) - CPP</th>
            <th>PAR (61 - 90) - Jml</th>
            <th>PAR (61 - 90) - Saldo Pokok</th>
            <th>PAR (61 - 90) - CPP</th>
            <th>PAR (91 - 120) - Jml</th>
            <th>PAR (91 - 120) - Saldo Pokok</th>
            <th>PAR (91 - 120) - CPP</th>
            <th>PAR (> 120) - Jml</th>
            <th>PAR (> 120) - Saldo Pokok</th>
            <th>PAR (> 120) - CPP</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($par as $pr)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $pr->keterangan }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $pr->jumlah_2 }}</td>
            <td style="border: 1px solid #000;">{{ $pr->saldo_pokok_2 }}</td>
            <td style="border: 1px solid #000;">{{ $pr->cpp_2 }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $pr->jumlah_3 }}</td>
            <td style="border: 1px solid #000;">{{ $pr->saldo_pokok_3 }}</td>
            <td style="border: 1px solid #000;">{{ $pr->cpp_3 }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $pr->jumlah_4 }}</td>
            <td style="border: 1px solid #000;">{{ $pr->saldo_pokok_4 }}</td>
            <td style="border: 1px solid #000;">{{ $pr->cpp_4 }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $pr->jumlah_5 }}</td>
            <td style="border: 1px solid #000;">{{ $pr->saldo_pokok_5 }}</td>
            <td style="border: 1px solid #000;">{{ $pr->cpp_5 }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $pr->jumlah_6 }}</td>
            <td style="border: 1px solid #000;">{{ $pr->saldo_pokok_6 }}</td>
            <td style="border: 1px solid #000;">{{ $pr->cpp_6 }}</td>
        </tr>
        @endforeach
        <tr>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;" colspan="2">TOTAL</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $total_jumlah_2 }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_pokok_2 }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_cpp_2 }}</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $total_jumlah_3 }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_pokok_3 }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_cpp_3 }}</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $total_jumlah_4 }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_pokok_4 }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_cpp_4 }}</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $total_jumlah_5 }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_pokok_5 }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_cpp_5 }}</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $total_jumlah_6 }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_saldo_pokok_6 }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_cpp_6 }}</td>
        </tr>
    </tbody>
</table>