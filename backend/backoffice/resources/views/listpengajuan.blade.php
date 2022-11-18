<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>Kumpulan</th>
            <th>No. Registrasi</th>
            <th>No. Anggota</th>
            <th>Nama</th>
            <th>No. KTP</th>
            <th>Tempat Lahir</th>
            <th>Tgl. Lahir</th>
            <th>No. Telp</th>
            <th>Petugas</th>
            <th>Jenis Pembiayaan</th>
            <th>Tgl. Pengajuan</th>
            <th>Rencana Cair</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($pengajuan as $pgj)

        @if($pgj->jenis_pembiayaan == 0)
        {{ $jenis_pembiayaan = 'Kelompok' }}
        @else
        {{ $jenis_pembiayaan = 'Individu' }}
        @endif

        @if($pgj->status_pengajuan == 0)
        {{ $status_pengajuan = 'Registrasi' }}
        @elseif($pgj->status_pengajuan == 1)
        {{ $status_pengajuan = 'Aktif' }}
        @endif
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $pgj->nama_cabang }}</td>
            <td>{{ $pgj->nama_rembug }}</td>
            <td>{{ $pgj->no_pengajuan }}</td>
            <td>'{{ $pgj->no_anggota }}</td>
            <td>{{ $pgj->nama_anggota }}</td>
            <td>'{{ $pgj->no_ktp }}</td>
            <td>{{ $pgj->tempat_lahir }}</td>
            <td>{{ @date('d/m/Y',@strtotime($pgj->tgl_lahir)) }}</td>
            <td>'{{ $pgj->no_telp }}</td>
            <td>{{ $pgj->nama_kas_petugas }}</td>
            <td>{{ $jenis_pembiayaan }}</td>
            <td>{{ @date('d/m/Y',@strtotime($pgj->tanggal_pengajuan)) }}</td>
            <td>{{ @date('d/m/Y',@strtotime($pgj->rencana_droping)) }}</td>
            <td>{{ $pgj->jumlah_pengajuan }}</td>
            <td>{{ $status_pengajuan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>