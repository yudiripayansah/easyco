<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="11">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="11">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="11">LAPORAN LIST SALDO ANGGOTA</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Kantor</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Majlis</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">Desa</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle" rowspan="2">No. Telp</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="5">Saldo</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Simpok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Simwa</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Sukarela</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Taber</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pembiayaan</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>Nama</th>
            <th>Majlis</th>
            <th>Desa</th>
            <th>No. Telp</th>
            <th>Saldo Simpok</th>
            <th>Saldo Simwa</th>
            <th>Saldo Sukarela</th>
            <th>Saldo Taber</th>
            <th>Saldo Pembiayaan</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($saldoanggota as $saldo)
        <tr>
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_cabang }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_rembug }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->desa }}</td>
            <td style="border: 1px solid #000;">'{{ $saldo->no_telp }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->simpok }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->simwa }}</td>
            <td style="border: 1px solid #000;">{{ (int) $saldo->simsuk }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->taber }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_outstanding }}</td>
        </tr>
        @endforeach
    </tbody>
</table>