<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="6">STATEMENT</th>
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
            <th>Nama</th>
            <th colspan="5">: {{ $nama }}</th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th colspan="5">: {{ $tanggal1 }} s.d {{ $tanggal2 }}</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tanggal</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Keterangan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Debit</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Credit</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Saldo</th>
        </tr>
        @endif
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #000;">-</td>
            <td style="border: 1px solid #000;">-</td>
            <td style="border: 1px solid #000;">Saldo Awal</td>
            <td style="border: 1px solid #000;">-</td>
            <td style="border: 1px solid #000;">-</td>
            <td style="border: 1px solid #000;">{{ $saldo_awal }}</td>
        </tr>
        @php $no = 1 @endphp
        @foreach($statementtabungan as $tabungan)
        <tr>
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $tabungan['trx_date'] }}</td>
            <td style="border: 1px solid #000;">{{ $tabungan['keterangan'] }}</td>
            <td style="border: 1px solid #000;">{{ $tabungan['tarik'] }}</td>
            <td style="border: 1px solid #000;">{{ $tabungan['setor'] }}</td>
            <td style="border: 1px solid #000;">{{ $tabungan['saldo_akhir'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>