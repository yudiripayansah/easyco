<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">{{ $detail->nama_cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">LAPORAN TRANSAKSI KAS PETUGAS</th>
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
            <th style="background-color:lightgray; font-size: 11px;">Pemegang Kas</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->nama_kas_petugas }}</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
        </tr>
        <tr>
            <th style="background-color:lightgray; font-size: 11px;">Tanggal</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->from_date }} s.d {{ $detail->thru_date }}</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
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
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tanggal</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Keterangan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Debet</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Credit</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Debet</th>
            <th>Credit</th>
            <th>Saldo</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp

        @foreach($saldo as $sld)
        {{$saldo = $sld->saldo_awal}}
        @endforeach

        @foreach($kaspetugas as $kas)

        @if($kas->debit_credit == 'D')
        {{ $debet = $kas->jumlah_trx }}
        {{ $credit = 0 }}
        {{ $saldo += $kas->jumlah_trx }}
        @else
        {{ $debet = 0 }}
        {{ $credit = $kas->jumlah_trx }}
        {{ $saldo -= $kas->jumlah_trx }}
        @endif
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $kas->voucher_date }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $kas->keterangan }}</td>
            <td style="border: 1px solid #000;">{{ $debet }}</td>
            <td style="border: 1px solid #000;">{{ $credit }}</td>
            <td style="border: 1px solid #000;">{{ $saldo }}</td>
        </tr>
        @endforeach
    </tbody>
</table>