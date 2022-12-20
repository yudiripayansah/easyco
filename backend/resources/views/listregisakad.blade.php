<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>Tgl. Registrasi</th>
            <th>Nama</th>
            <th>Rembug</th>
            <th>No. Rekening</th>
            <th>Produk</th>
            <th>Plafon</th>
            <th>Margin</th>
            <th>Jangka Waktu</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($regisakad as $akad)

        @if($akad->periode_jangka_waktu == 0)
        {{ $periode = 'Harian' }}
        @elseif($akad->periode_jangka_waktu == 1)
        {{ $periode = 'Mingguan' }}
        @elseif($akad->periode_jangka_waktu == 2)
        {{ $periode = 'Bulanan' }}
        @else
        {{ $periode = 'Tempo' }}
        @endif
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $akad->nama_cabang }}</td>
            <td>{{ $akad->tanggal_akad }}</td>
            <td>{{ $akad->nama_anggota }}</td>
            <td>{{ $akad->nama_rembug }}</td>
            <td>'{{ $akad->no_rekening }}</td>
            <td>{{ $akad->nama_produk }}</td>
            <td>{{ $akad->pokok }}</td>
            <td>{{ $akad->margin }}</td>
            <td>{{ $akad->jangka_waktu }} {{ $periode }}</td>
        </tr>
        @endforeach
    </tbody>
</table>