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
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="8">LAPORAN LIST PENGAJUAN</th>
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
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Kantor</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Tgl. Pengajuan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Rembug</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">No. Pengajuan</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Jumlah</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid #000;">Status</th>
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
            <td style="border: 1px solid #000;">{{ $no++ }}</td>
            <td style="border: 1px solid #000;">{{ $pgj->nama_cabang }}</td>
            <td style="border: 1px solid #000;">{{ $pgj->tanggal_pengajuan }}</td>
            <td style="border: 1px solid #000;">{{ $pgj->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $pgj->nama_rembug }}</td>
            <td style="border: 1px solid #000;">{{ $pgj->no_pengajuan }}</td>
            <td style="border: 1px solid #000;">{{ $pgj->jumlah_pengajuan }}</td>
            <td style="border: 1px solid #000;">{{ $status_pengajuan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>