<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="7">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="7">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="7">{{ $tanggal }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="7">LAPORAN LIST SALDO KAS PETUGAS</th>
        </tr>
        <tr>
            <th colspan="13">&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;">Kode Kas Petugas</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;">Pemegang Kas</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;">Saldo Awal</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;">Mutasi Debet</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;">Mutasi Kredit</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;">Saldo Akhir</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Kas Petugas</th>
            <th>Pemegang Kas</th>
            <th>Saldo Awal</th>
            <th>Mutasi Debet</th>
            <th>Mutasi Kredit</th>
            <th>Saldo Akhir</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($saldokaspetugas as $saldo)
        <tr>
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">'{{ $saldo->kode_kas_petugas }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_kas_petugas }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_awal }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->mutasi_debet }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->mutasi_credit }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_akhir }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">Keterangan</td>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">Saldo</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border: 1px solid #000;">Total Saldo Awal</td>
            <td style="border: 1px solid #000;">{{ $total_saldo_awal }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border: 1px solid #000;">Total Saldo Akhir</td>
            <td style="border: 1px solid #000;">{{ $total_saldo_akhir }}</td>
        </tr>
    </tfoot>
</table>