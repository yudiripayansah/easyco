<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tgl. Akad</th>
            <th>Nama</th>
            <th>Rembug</th>
            <th>No. Rekening</th>
            <th>Produk</th>
            <th>Plafon</th>
            <th>Margin</th>
            <th>Jangka Waktu</th>
            <th>Petugas</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($pencairan as $cair)

        @if($cair->periode_jangka_waktu == 0)
        {{ $periode = 'Harian' }}
        @elseif($cair->periode_jangka_waktu == 1)
        {{ $periode = 'Mingguan' }}
        @elseif($cair->periode_jangka_waktu == 2)
        {{ $periode = 'Bulanan' }}
        @else
        {{ $periode = 'Tempo' }}
        @endif
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $cair->tanggal_akad }}</td>
            <td>{{ $cair->nama_anggota }}</td>
            <td>{{ $cair->nama_rembug }}</td>
            <td>'{{ $cair->no_rekening }}</td>
            <td>{{ $cair->nama_produk }}</td>
            <td>{{ $cair->pokok }}</td>
            <td>{{ $cair->margin }}</td>
            <td>{{ $cair->jangka_waktu }} {{ $periode }}</td>
            <td>{{ $cair->nama_petugas }}</td>
        </tr>
        @endforeach
    </tbody>
</table>