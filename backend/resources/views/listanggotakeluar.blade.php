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
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">LAPORAN LIST ANGGOTA KELUAR</th>
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
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2">No</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2">Kantor</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2">Kumpulan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2">No. Anggota</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2">Alasan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2">Keterangan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2">Tgl. Keluar</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="10">Saldo</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2">Petugas</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Margin</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Minggon</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Sukarela</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Taber</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Deposito</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Simpok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tab 5%</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Bonus Bagihasil</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Penarikan</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>Kumpulan</th>
            <th>No. Anggota</th>
            <th>Nama</th>
            <th>Alasan</th>
            <th>Keterangan</th>
            <th>Tgl. Keluar</th>
            <th>Saldo Pokok</th>
            <th>Saldo Margin</th>
            <th>Saldo Minggon</th>
            <th>Saldo Sukarela</th>
            <th>Saldo Taber</th>
            <th>Saldo Deposito</th>
            <th>Saldo Simpok</th>
            <th>Saldo Tab 5%</th>
            <th>Bonus Bagihasil</th>
            <th>Penarikan</th>
            <th>Petugas</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($anggotakeluar as $keluar)

        @if ($keluar->alasan_mutasi == 1)
        {{ $alasan = 'Meninggal' }}
        @elseif ($keluar->alasan_mutasi == 2)
        {{ $alasan = 'Karakter' }}
        @elseif ($keluar->alasan_mutasi == 3)
        {{ $alasan = 'Pindah Lembaga Lain' }}
        @elseif ($keluar->alasan_mutasi == 4)
        {{ $alasan = 'Tidak diijinkan Pasangan' }}
        @elseif ($keluar->alasan_mutasi == 5)
        {{ $alasan = 'Simpanan Kurang' }}
        @elseif ($keluar->alasan_mutasi == 6)
        {{ $alasan = 'Kondisi Keluarga' }}
        @elseif ($keluar->alasan_mutasi == 7)
        {{ $alasan = 'Pindah Alamat' }}
        @elseif ($keluar->alasan_mutasi == 8)
        {{ $alasan = 'Tidak Setuju Keputusan Lembaga' }}
        @elseif ($keluar->alasan_mutasi == 9)
        {{ $alasan = 'Usia / Jompo' }}
        @elseif ($keluar->alasan_mutasi == 10)
        {{ $alasan = 'Sakit' }}
        @elseif ($keluar->alasan_mutasi == 11)
        {{ $alasan = 'Kumpulan Bubar' }}
        @elseif ($keluar->alasan_mutasi == 12)
        {{ $alasan = 'Tidak Punya Waktu' }}
        @elseif ($keluar->alasan_mutasi == 13)
        {{ $alasan = 'Kerja' }}
        @elseif ($keluar->alasan_mutasi == 14)
        {{ $alasan = 'Cerai' }}
        @elseif ($keluar->alasan_mutasi == 15)
        {{ $alasan = 'Pembiayaan Bermasalah' }}
        @elseif ($keluar->alasan_mutasi == 16)
        {{ $alasan = 'Usaha Sudah Berkembang' }}
        @elseif ($keluar->alasan_mutasi == 17)
        {{ $alasan = 'Tidak Mau Kumpulan' }}
        @elseif ($keluar->alasan_mutasi == 18)
        {{ $alasan = 'Batal Pembiayaan (Anggota baru)' }}
        @else
        {{ $alasan = 'Migrasi Anggota Individu' }}
        @endif
        <tr>
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->nama_cabang }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->nama_rembug }}</td>
            <td style="border: 1px solid #000;">'{{ $keluar->no_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $alasan }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->keterangan_mutasi }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->tanggal_mutasi }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->saldo_pokok }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->saldo_margin }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->saldo_minggon }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->saldo_sukarela }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->saldo_tab_berencana }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->saldo_deposito }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->saldo_simpok }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->saldo_simwa }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->bonus_bagihasil }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->penarikan_sukarela }}</td>
            <td style="border: 1px solid #000;">{{ $keluar->nama_pgw }}</td>
        </tr>
        @endforeach
    </tbody>
</table>