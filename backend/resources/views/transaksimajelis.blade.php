<table>
    <thead>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="13">KSPPS MITRA SEJAHTERA RAYA INDONESIA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="13">{{ $head->nama_cabang }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; font-size: 12px;" colspan="13">LAPORAN TRANSAKSI MAJELIS</th>
        </tr>
    </thead>
    <tbody>
        {{ $grand_total_angsuran_pokok = 0 }}
        {{ $grand_total_angsuran_margin = 0 }}
        {{ $grand_total_angsuran_catab = 0 }}
        {{ $grand_total_setoran_sukarela = 0 }}
        {{ $grand_total_setoran_simpok = 0 }}
        {{ $grand_total_setoran_taber = 0 }}
        {{ $grand_total_penarikan_sukarela = 0 }}
        {{ $grand_total_pokok = 0 }}
        {{ $grand_total_biaya_administrasi = 0 }}
        {{ $grand_total_biaya_asuransi_jiwa = 0 }}

        @foreach($transaksimajelis as $tmajelis)
        <tr>
            <td colspan="13">&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 11px; font-weight: bold;">Majelis</td>
            <td style="font-size: 11px;">: {{ $tmajelis->nama_rembug }}</td>
            <td style="font-size: 11px;">&nbsp;</td>
            <td style="font-size: 11px; font-weight: bold;">Tgl. Bayar</td>
            <td style="font-size: 11px;">: {{ $tmajelis->tanggal_bayar }}</td>
            <td style="font-size: 11px;">&nbsp;</td>
            <td style="font-size: 11px; font-weight: bold;">Status Verifikasi</td>
            <td style="font-size: 11px;">: {{ $tmajelis->status_verifikasi }}</td>
            <td style="font-size: 11px;">&nbsp;</td>
            <td style="font-size: 11px;">&nbsp;</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; background-color:lightgray;">Infaq</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; background-color:lightgray;">Total Setoran</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; background-color:lightgray;">Total Penarikan</td>
        </tr>
        <tr>
            <td style="font-size: 11px; font-weight: bold;">Petugas</td>
            <td style="font-size: 11px;">: {{ $tmajelis->nama_petugas }}</td>
            <td style="font-size: 11px;">&nbsp;</td>
            <td style="font-size: 11px; font-weight: bold;">Tgl. Transaksi</td>
            <td style="font-size: 11px;">: {{ $tmajelis->tanggal }}</td>
            <td style="font-size: 11px;">&nbsp;</td>
            <td style="font-size: 11px;">&nbsp;</td>
            <td style="font-size: 11px;">&nbsp;</td>
            <td style="font-size: 11px;">&nbsp;</td>
            <td style="font-size: 11px;">&nbsp;</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $tmajelis->infaq }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $tmajelis->total_penerimaan }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $tmajelis->total_penarikan }}</td>
        </tr>
        <tr>
            <td colspan="13">&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center; vertical-align: middle" colspan="2" rowspan="2">ANGGOTA</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;" colspan="7">SETORAN</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;">PENARIKAN</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;" colspan="3">PENCAIRAN PEMBIAYAAN</td>
        </tr>
        <tr>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;" colspan="4">ANGSURAN</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center; vertical-align: middle;" rowspan="2">Tab. Sukarela</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center; vertical-align: middle;" rowspan="2">Tab. Simwa/Simpok</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center; vertical-align: middle;" rowspan="2">Tab. Berencana</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center; vertical-align: middle;" rowspan="2">Tab. Sukarela</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center; vertical-align: middle;" rowspan="2">Pokok</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center; vertical-align: middle;" rowspan="2">Administrasi</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center; vertical-align: middle;" rowspan="2">Asuransi</td>
        </tr>
        <tr>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;">ID</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;">Nama</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;">Frek</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;">Pokok</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;">Margin</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;">Catab</td>
        </tr>
        {{ $total_angsuran_pokok = 0 }}
        {{ $total_angsuran_margin = 0 }}
        {{ $total_angsuran_catab = 0 }}
        {{ $total_setoran_sukarela = 0 }}
        {{ $total_setoran_simpok = 0 }}
        {{ $total_setoran_taber = 0 }}
        {{ $total_penarikan_sukarela = 0 }}
        {{ $total_pokok = 0 }}
        {{ $total_biaya_administrasi = 0 }}
        {{ $total_biaya_asuransi_jiwa = 0 }}

        @foreach($detail as $dtl)
        @if($dtl->id_trx_rembug == $tmajelis->id_trx_rembug)
        {{ $total_angsuran_pokok += $dtl->angsuran_pokok }}
        {{ $total_angsuran_margin += $dtl->angsuran_margin }}
        {{ $total_angsuran_catab += $dtl->angsuran_catab }}
        {{ $total_setoran_sukarela += $dtl->setoran_sukarela }}
        {{ $total_setoran_simpok += $dtl->setoran_simpok }}
        {{ $total_setoran_taber += $dtl->setoran_taber }}
        {{ $total_penarikan_sukarela += $dtl->penarikan_sukarela }}
        {{ $total_pokok += $dtl->pokok }}
        {{ $total_biaya_administrasi += $dtl->biaya_administrasi }}
        {{ $total_biaya_asuransi_jiwa += $dtl->biaya_asuransi_jiwa }}
        <tr>
            <td style="font-size: 11px; border: 1px solid #000; text-align: center;">'{{ $dtl->no_anggota }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->nama_anggota }}</td>
            <td style="font-size: 11px; border: 1px solid #000; text-align: center;">{{ $dtl->frek }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->angsuran_pokok }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->angsuran_margin }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->angsuran_catab }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->setoran_sukarela }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->setoran_simpok }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->setoran_taber }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->penarikan_sukarela }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->pokok }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->biaya_administrasi }}</td>
            <td style="font-size: 11px; border: 1px solid #000;">{{ $dtl->biaya_asuransi_jiwa }}</td>
        </tr>
        @endif
        @endforeach
        <tr>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;" colspan="3">TOTAL</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $total_angsuran_pokok }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $total_angsuran_margin }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $total_angsuran_catab }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $total_setoran_sukarela }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $total_setoran_simpok }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $total_setoran_taber }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $total_penarikan_sukarela }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $total_pokok }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $total_biaya_administrasi }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $total_biaya_asuransi_jiwa }}</td>
        </tr>
        {{ $grand_total_angsuran_pokok += $total_angsuran_pokok }}
        {{ $grand_total_angsuran_margin += $total_angsuran_margin }}
        {{ $grand_total_angsuran_catab += $total_angsuran_catab }}
        {{ $grand_total_setoran_sukarela += $total_setoran_sukarela }}
        {{ $grand_total_setoran_simpok += $total_setoran_simpok }}
        {{ $grand_total_setoran_taber += $total_setoran_taber }}
        {{ $grand_total_penarikan_sukarela += $total_penarikan_sukarela }}
        {{ $grand_total_pokok += $total_pokok }}
        {{ $grand_total_biaya_administrasi += $total_biaya_administrasi }}
        {{ $grand_total_biaya_asuransi_jiwa += $total_biaya_asuransi_jiwa }}

        @endforeach
        <tr>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000; text-align: center;" colspan="3">GRAND TOTAL</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $grand_total_angsuran_pokok }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $grand_total_angsuran_margin }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $grand_total_angsuran_catab }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $grand_total_setoran_sukarela }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $grand_total_setoran_simpok }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $grand_total_setoran_taber }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $grand_total_penarikan_sukarela }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $grand_total_pokok }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $grand_total_biaya_administrasi }}</td>
            <td style="font-size: 11px; font-weight: bold; border: 1px solid #000;">{{ $grand_total_biaya_asuransi_jiwa }}</td>
        </tr>
    </tbody>
</table>