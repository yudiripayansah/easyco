<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>Kumpulan</th>
            <th>No. Anggota</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Ibu Kandung</th>
            <th>Tempat Lahir</th>
            <th>Tgl. Lahir</th>
            <th>Alamat</th>
            <th>Desa</th>
            <th>Kecamatan</th>
            <th>Kabupaten</th>
            <th>No. KTP</th>
            <th>No. Telp</th>
            <th>Pendidikan</th>
            <th>Status Pernikahan</th>
            <th>Nama Pasangan</th>
            <th>Pekerjaan</th>
            <th>Ket. Pekerjaan</th>
            <th>Pend. Bulanan</th>
            <th>Tgl. Gabung</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($anggotamasuk as $masuk)

        @if($masuk->pendidikan == 0)
        {{ $pendidikan = 'Tidak Diketahui' }}
        @elseif($masuk->pendidikan == 1)
        {{ $pendidikan = 'SD / MI' }}
        @elseif($masuk->pendidikan == 2)
        {{ $pendidikan = 'SMP / MTs' }}
        @elseif($masuk->pendidikan == 3)
        {{ $pendidikan = 'SMK / SMA / MA' }}
        @elseif($masuk->pendidikan == 4)
        {{ $pendidikan = 'D1' }}
        @elseif($masuk->pendidikan == 5)
        {{ $pendidikan = 'D2' }}
        @elseif($masuk->pendidikan == 6)
        {{ $pendidikan = 'D3' }}
        @elseif($masuk->pendidikan == 7)
        {{ $pendidikan = 'S1' }}
        @elseif($masuk->pendidikan == 8)
        {{ $pendidikan = 'S2' }}
        @else
        {{ $pendidikan = 'S3' }}
        @endif
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $masuk->nama_cabang }}</td>
            <td>{{ $masuk->nama_rembug }}</td>
            <td>'{{ $masuk->no_anggota }}</td>
            <td>{{ $masuk->nama_anggota }}</td>
            <td>{{ (($masuk->jenis_kelamin == 'P') ? 'Pria' : 'Wanita') }}</td>
            <td>{{ $masuk->ibu_kandung }}</td>
            <td>{{ $masuk->tempat_lahir }}</td>
            <td>{{ @date('d/m/Y',@strtotime($masuk->tgl_lahir)) }}</td>
            <td>{{ $masuk->alamat }}</td>
            <td>{{ $masuk->desa }}</td>
            <td>{{ $masuk->kecamatan }}</td>
            <td>{{ $masuk->kabupaten }}</td>
            <td>'{{ $masuk->no_ktp }}</td>
            <td>'{{ $masuk->no_telp }}</td>
            <td>{{ $pendidikan }}</td>
            <td>{{ $masuk->status_perkawinan }}</td>
            <td>{{ $masuk->nama_pasangan }}</td>
            <td>{{ $masuk->pekerjaan }}</td>
            <td>{{ $masuk->ket_pekerjaan }}</td>
            <td>{{ $masuk->pendapatan_perbulan }}</td>
            <td>{{ @date('d/m/Y',@strtotime($masuk->tgl_gabung)) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>