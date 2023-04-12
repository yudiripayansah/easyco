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
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">LAPORAN LIST ANGGOTA MASUK</th>
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
        </tr>
        @endif
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Cabang</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tgl. Gabung</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">NIK</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No. Anggota</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Rembug</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Status</th>
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
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $masuk->nama_cabang }}</td>
            <td style="border: 1px solid #000;">{{ $masuk->tgl_gabung }}</td>
            <td style="border: 1px solid #000;">{{ $masuk->nama_anggota }}</td>
            <td style="border: 1px solid #000;">'{{ $masuk->no_ktp }}</td>
            <td style="border: 1px solid #000;">'{{ $masuk->no_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $masuk->nama_rembug }}</td>
            <td style="border: 1px solid #000;">{{ $status_keanggotaan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>