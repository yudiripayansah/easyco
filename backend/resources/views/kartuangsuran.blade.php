<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">LAPORAN KARTU ANGSURAN</th>
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
            <th style="background-color:lightgray; font-size: 11px;">Nama</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->nama_anggota }}</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">Tgl. Cair</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->tanggal_akad }}</th>
        </tr>
        <tr>
            <th style="background-color:lightgray; font-size: 11px;">Majelis</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->nama_rembug }}</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">Saldo Pokok</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->saldo_pokok }}</th>
        </tr>
        <tr>
            <th style="background-color:lightgray; font-size: 11px;">Produk</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->nama_singkat }}</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">Saldo Margin</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->saldo_margin }}</th>
        </tr>
        <tr>
            <th style="background-color:lightgray; font-size: 11px;">Pokok</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->pokok }}</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">Pembiayaan Ke</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->pengajuan_ke }}</th>
        </tr>
        <tr>
            <th style="background-color:lightgray; font-size: 11px;">Margin</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->margin }}</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">&nbsp;</th>
            <th style="background-color:lightgray; font-size: 11px;">Status</th>
            <th style="background-color:lightgray; font-size: 11px;">: {{ $detail->status_rekening }}</th>
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
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" colspan="2">Tanggal</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" colspan="2">Angsuran</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" colspan="2">Saldo</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Angsur</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Bayar</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Ke</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jumlah</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Margin</th>
        </tr>
        @else
        <tr>
            <th>Tanggal Angsur</th>
            <th>Tanggal Bayar</th>
            <th>Angsuran Ke</th>
            <th>Angsuran Jumlah</th>
            <th>Saldo Pokok</th>
            <th>Saldo Margin</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @foreach($kartuangsuran as $karwas)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $karwas->tgl_angsuran }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $karwas->tgl_bayar }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $karwas->angsuran_ke }}</td>
            <td style="border: 1px solid #000;">{{ $karwas->angsuran_pokok+$karwas->angsuran_margin }}</td>
            <td style="border: 1px solid #000;">{{ $karwas->saldo_pokok }}</td>
            <td style="border: 1px solid #000;">{{ $karwas->saldo_margin }}</td>
        </tr>
        @endforeach
    </tbody>
</table>