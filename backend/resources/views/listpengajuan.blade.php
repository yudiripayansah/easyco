<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>Tgl. Pengajuan</th>
            <th>Nama</th>
            <th>Rembug</th>
            <th>No. Pengajuan</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($pengajuan as $pgj)

        @if($pgj->status_pengajuan == 0)
        {{ $status_pengajuan = 'Registrasi' }}
        @elseif($pgj->status_pengajuan == 1)
        {{ $status_pengajuan = 'Cair' }}
        @elseif($pgj->status_pengajuan == 2)
        {{ $status_pengajuan = 'Ditolak' }}
        @else
        {{ $status_pengajuan = 'Batal' }}
        @endif
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $pgj->nama_cabang }}</td>
            <td>{{ $pgj->tanggal_pengajuan }}</td>
            <td>{{ $pgj->nama_anggota }}</td>
            <td>{{ $pgj->nama_rembug }}</td>
            <td>{{ $pgj->no_pengajuan }}</td>
            <td>{{ $pgj->jumlah_pengajuan }}</td>
            <td>{{ $status_pengajuan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>