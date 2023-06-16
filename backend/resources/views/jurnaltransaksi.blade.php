<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="7">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="7">{{ $head->nama_cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="7">LAPORAN JURNAL TRANSAKSI</th>
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
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tgl. Voucher</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Keterangan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Account</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Debet</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Credit</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Tgl. Transaksi</th>
            <th>Tgl. Voucher</th>
            <th>Keterangan</th>
            <th>Account</th>
            <th>Debet</th>
            <th>Credit</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($jurnaltransaksi as $jurnal)
        <tr>
            <td style="border: 1px solid #000; vertical-align: middle; text-align: center;">{{ $no++ }}</td>
            <td style="border: 1px solid #000; vertical-align: middle; text-align: center;">{{ $jurnal->trx_date }}</td>
            <td style="border: 1px solid #000; vertical-align: middle; text-align: center;">{{ $jurnal->voucher_date }}</td>
            <td style="border: 1px solid #000; vertical-align: middle;" colspan="4">{{ $jurnal->description }}</td>
        </tr>
        @foreach($detail as $dtl)
        @if($dtl->id_trx_gl == $jurnal->id_trx_gl)
        @if($dtl->flag_dc == 'D')
        {{ $debet = $dtl->amount }}
        {{ $credit = 0 }}
        @else
        {{ $debet = 0 }}
        {{ $credit = $dtl->amount }}
        @endif
        <tr>
            <td style="border: 1px solid #000;" colspan="4">&nbsp;</td>
            <td style="border: 1px solid #000;">{{ $dtl->kode_gl }} - {{ $dtl->nama_gl }}</td>
            <td style="border: 1px solid #000;">{{ $debet }}</td>
            <td style="border: 1px solid #000;">{{ $credit }}</td>
        </tr>
        @endif
        @endforeach
        @endforeach
    </tbody>
</table>