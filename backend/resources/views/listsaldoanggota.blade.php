<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="15">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="15">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="15">LAPORAN LIST SALDO ANGGOTA</th>
        </tr>
        <tr>
            <th colspan="13">&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="3">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="3">Kantor</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="3">ID Anggota</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="3">NIK</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="3">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="3">Majelis</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="3">Desa</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="3">No. Telp</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="7">Saldo</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="2">Simpok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="2">Simwa</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="2">Sukarela</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="2">Taber</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000; vertical-align: middle;" rowspan="2">Tab 5%</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="2">Pembiayaan</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Margin</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>ID Anggota</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Majelis</th>
            <th>Desa</th>
            <th>No. Telp</th>
            <th>Saldo Simpok</th>
            <th>Saldo Simwa</th>
            <th>Saldo Sukarela</th>
            <th>Saldo Taber</th>
            <th>Saldo Tab 5%</th>
            <th>Saldo Pokok</th>
            <th>Saldo Margin</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($saldoanggota as $saldo)
        <tr>
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_cabang }}</td>
            <td style="border: 1px solid #000;">'{{ $saldo->no_anggota }}</td>
            <td style="border: 1px solid #000;">'{{ $saldo->no_ktp }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->nama_rembug }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->desa }}</td>
            <td style="border: 1px solid #000;">'{{ $saldo->no_telp }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->simpok }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->simwa }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->simsuk }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_taber }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_tab_5 }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_pokok }}</td>
            <td style="border: 1px solid #000;">{{ $saldo->saldo_margin }}</td>
        </tr>
        @endforeach
    </tbody>
</table>