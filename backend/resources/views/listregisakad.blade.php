<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>Kumpulan</th>
            <th>No. Anggota</th>
            <th>Nama</th>
            <th>No. Rekening</th>
            <th>Tempat Lahir</th>
            <th>Tgl. Lahir</th>
            <th>Usia</th>
            <th>No. Telp</th>
            <th>Desa</th>
            <th>Tgl. Registrasi</th>
            <th>Pembiayaan Ke</th>
            <th>Pokok</th>
            <th>Margin</th>
            <th>Angsuran</th>
            <th>Biaya Administrasi</th>
            <th>Biaya Asuransi Jiwa</th>
            <th>Dana Kebajikan</th>
            <th>Jangka Waktu</th>
            <th>Tgl. Akad</th>
            <th>Sumber Dana</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($regisakad as $akad)

        @if($akad->status_rekening == 0)
        {{ $status_rekening = 'Registrasi' }}
        @elseif($akad->status_rekening == 1)
        {{ $status_rekening = 'Aktif' }}
        @elseif($akad->status_rekening == 2)
        {{ $status_rekening = 'Lunas' }}
        @else
        {{$status_rekening = 'Verifikasi Anggota Keluar'}}
        @endif

        @if($akad->periode_jangka_waktu == 0)
        {{ $periode = 'Harian' }}
        @elseif($akad->periode_jangka_waktu == 1)
        {{ $periode = 'Mingguan' }}
        @elseif($akad->periode_jangka_waktu == 2)
        {{ $periode = 'Bulanan' }}
        @else
        {{ $periode = 'Tempo' }}
        @endif

        @if($akad->sumber_dana == 0)
        {{ $sumber_dana = 'Sendiri' }}
        @elseif($akad->sumber_dana == 1)
        {{ $sumber_dana = 'Kreditur' }}
        @else
        {{ $sumber_dana = 'Campuran' }}
        @endif
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $akad->nama_cabang }}</td>
            <td>{{ $akad->nama_rembug }}</td>
            <td>'{{ $akad->no_anggota }}</td>
            <td>{{ $akad->nama_anggota }}</td>
            <td>'{{ $akad->no_rekening }}</td>
            <td>{{ $akad->tempat_lahir }}</td>
            <td>{{ @date('d/m/Y',@strtotime($akad->tgl_lahir)) }}</td>
            <td>{{ $akad->usia }}</td>
            <td>{{ $akad->no_telp }}</td>
            <td>{{ $akad->nama_desa }}</td>
            <td>{{ @date('d/m/Y',@strtotime($akad->tanggal_registrasi)) }}</td>
            <td>{{ $akad->pengajuan_ke }}</td>
            <td>{{ $akad->pokok }}</td>
            <td>{{ $akad->margin }}</td>
            <td>{{ $akad->angsuran }}</td>
            <td>{{ $akad->biaya_administrasi }}</td>
            <td>{{ $akad->biaya_asuransi_jiwa }}</td>
            <td>{{ $akad->dana_kebajikan }}</td>
            <td>{{ $akad->jangka_waktu }} {{ $periode }}</td>
            <td>{{ @date('d/m/Y',@strtotime($akad->tanggal_akad)) }}</td>
            <td>{{ $sumber_dana }}</td>
            <td>{{ $status_rekening }}</td>
        </tr>
        @endforeach
    </tbody>
</table>