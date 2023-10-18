<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">LAPORAN REKAP PENGAJUAN</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">PERIODE : {{ $tanggal1 }} s.d {{ $tanggal2 }}</th>
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
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Kantor</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Jumlah</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" valign="middle" rowspan="2">Nominal</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="2">Persentase</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jumlah (%)</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Nominal (%)</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>Jumlah</th>
            <th>Nominal</th>
            <th>Persentase Jumlah</th>
            <th>Persentase Nominal</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($pengajuan as $pgj)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $pgj->keterangan }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $pgj->jumlah_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $pgj->nominal }}</td>
            <td style="border: 1px solid #000;">{{ $pgj->persen_jumlah }}</td>
            <td style="border: 1px solid #000;">{{ $pgj->persen_nominal }}</td>
        </tr>
        @endforeach
        <tr>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;" colspan="2">TOTAL</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $total_anggota }}</td>
            <td style="border: 1px solid #000; font-weight: bold;">{{ $total_pokok }}</td>
        </tr>
    </tbody>
</table>