<table>
    <thead>
        @if($format == 'excel')
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="26">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="26">{{ $cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="26">LAPORAN LIST KOLEKTIBILITAS</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="26">TANGGAL : {{ $tanggal_hitung }}</th>
        </tr>
        <tr>
            <th colspan="26">&nbsp;</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">NO</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">KANTOR</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="4">ANGGOTA</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="6">PENCAIRAN</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="4">ANGSURAN</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="2">OUTSTANDING</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="4">TUNGGAKAN</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">PAR</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" colspan="2">CPP</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;" rowspan="2" valign="middle">PETUGAS</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No. Rekening</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Kumpulan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">ID Anggota</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Margin</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jangka Waktu</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tgl. Cair</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tgl. Mulai Angsur</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Pengajuan Ke</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Angsuran Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Angsuran Margin</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Terbayar</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Seharusnya</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Margin</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Hari Nunggak</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Freq Tunggakan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tunggakan Pokok</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tunggakan Margin</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">%</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Cadangan Piutang</th>
        </tr>
        @else
        <tr>
            <th>No</th>
            <th>Kantor</th>
            <th>No. Rekening</th>
            <th>Kumpulan</th>
            <th>ID Anggota</th>
            <th>Nama</th>
            <th>Pokok</th>
            <th>Margin</th>
            <th>Jangka Waktu</th>
            <th>Tgl. Cair</th>
            <th>Tgl. Mulai Angsur</th>
            <th>Pengajuan Ke</th>
            <th>Angsuran Pokok</th>
            <th>Angsuran Margin</th>
            <th>Terbayar</th>
            <th>Seharusnya</th>
            <th>Saldo Pokok</th>
            <th>Saldo Margin</th>
            <th>Hari Nunggak</th>
            <th>Freq Tunggakan</th>
            <th>Tunggakan Pokok</th>
            <th>Tunggakan Margin</th>
            <th>Keterangan</th>
            <th>CPP</th>
            <th>Cadangan Piutang</th>
            <th>Petugas</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($kolektibilitas as $kolek)
        <tr>
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->nama_cabang }}</td>
            <td style="border: 1px solid #000;">'{{ $kolek->no_rekening }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->nama_rembug }}</td>
            <td style="border: 1px solid #000;">'{{ $kolek->no_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->pokok }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->margin }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->jangka_waktu }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->tanggal_akad }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->tanggal_mulai_angsur }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->pengajuan_ke }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->angsuran_pokok }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->angsuran_margin }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->angsuran_terbayar }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->seharusnya }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->saldo_pokok }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->saldo_margin }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->hari_nunggak }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->freq_tunggakan }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->tunggakan_pokok }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->tunggakan_margin }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->par_desc }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->cpp }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->cadangan_piutang }}</td>
            <td style="border: 1px solid #000;">{{ $kolek->nama_pgw }}</td>
        </tr>
        @endforeach
    </tbody>
</table>