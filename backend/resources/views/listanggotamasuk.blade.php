<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Cabang</th>
            <th>Tgl. Gabung</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>No. Anggota</th>
            <th>Rembug</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($anggotamasuk as $masuk)

        @if($masuk->status == 0)
        {{ $status_keanggotaan = 'Calon Anggota' }}
        @elseif($masuk->status == 1)
        {{ $status_keanggotaan = 'Anggota' }}
        @elseif($masuk->status == 2)
        {{ $status_keanggotaan = 'Keluar' }}
        @else
        {{ $status_keanggotaan = 'Menunggu Verifikasi Anggota Keluar' }}
        @endif
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $masuk->nama_cabang }}</td>
            <td>{{ $masuk->tgl_gabung }}</td>
            <td>{{ $masuk->nama_anggota }}</td>
            <td>'{{ $masuk->no_ktp }}</td>
            <td>'{{ $masuk->no_anggota }}</td>
            <td>{{ $masuk->nama_rembug }}</td>
            <td>{{ $status_keanggotaan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>