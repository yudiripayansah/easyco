<table>
    <thead>
        <tr>
            <td rowspan="2" valign="middle" align="center">No</td>
            <td rowspan="2" valign="middle" align="center">Kantor</td>
            <td rowspan="2" valign="middle" align="center">Nama</td>
            <td rowspan="2" valign="middle" align="center">Majlis</td>
            <td rowspan="2" valign="middle" align="center">Desa</td>
            <td rowspan="2" valign="middle" align="center">No. Telp</td>
            <td colspan="5" align="center">Saldo</td>
        </tr>
        <tr>
            <td align="center">Saldo Simpok</td>
            <td align="center">Saldo Simwa</td>
            <td align="center">Saldo Sukarela</td>
            <td align="center">Saldo Taber</td>
            <td align="center">Saldo Pembiayaan</td>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($saldoanggota as $saldo)
        <tr>
            <td align="center">{{ $no++ }}</td>
            <td>{{ $saldo->nama_cabang }}</td>
            <td>{{ $saldo->nama_anggota }}</td>
            <td>{{ $saldo->nama_rembug }}</td>
            <td>{{ $saldo->desa }}</td>
            <td>'{{ $saldo->no_telp }}</td>
            <td>{{ $saldo->simpok }}</td>
            <td>{{ $saldo->simwa }}</td>
            <td>{{ $saldo->sukarela }}</td>
            <td>{{ $saldo->taber }}</td>
            <td>{{ $saldo->saldo_outstanding }}</td>
        </tr>
        @endforeach
    </tbody>
</table>