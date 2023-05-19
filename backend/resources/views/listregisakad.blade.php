<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">LAPORAN LIST REGISTRASI AKAD</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">PERIODE : {{ $tanggal1 }} s.d {{ $tanggal2 }}</th>
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
        </tr>
        @endif
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Kantor</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tgl. Registrasi</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Rembug</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No. Rekening</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Produk</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Plafon</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Margin</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jangka Waktu</th>
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
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $akad->nama_cabang }}</td>
            <td style="border: 1px solid #000;">{{ $akad->tanggal_akad }}</td>
            <td style="border: 1px solid #000;">{{ $akad->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $akad->nama_rembug }}</td>
            <td style="border: 1px solid #000;">'{{ $akad->no_rekening }}</td>
            <td style="border: 1px solid #000;">{{ $akad->nama_produk }}</td>
            <td style="border: 1px solid #000;">{{ $akad->pokok }}</td>
            <td style="border: 1px solid #000;">{{ $akad->margin }}</td>
            <td style="border: 1px solid #000;">{{ $akad->jangka_waktu }} {{ $periode }}</td>
        </tr>
        @endforeach
    </tbody>
</table>