const menu = [
  {
    target: '/dashboard',
    label: 'Dashboard',
    icon: 'menu-icon flaticon2-architecture-and-city',
  },
  // Keanggotaan
  {
    target: '/keanggotaan',
    label: 'Keanggotaan',
    icon: 'menu-icon far fa-user',
    children: [
      {
        target: '/keanggotaan/registrasi-anggota',
        label: 'Registrasi Anggota'
      },
      {
        target: '/keanggotaan/approval-registrasi',
        label: 'Approval Registrasi'
      },
      {
        target: '/keanggotaan/registrasi-anggota-keluar',
        label: 'Registrasi Anggota Keluar'
      },
      {
        target: '/keanggotaan/approval-registrasi-keluar',
        label: 'Approval Registrasi Anggota Keluar'
      },
      {
        target: '/keanggotaan/transaksi-anggota',
        label: 'Transaksi Anggota'
      },
      {
        target: '/keanggotaan/laporan',
        label: 'Laporan',
        children: [
          {
            target: '/keanggotaan/laporan/registrasi-anggota',
            label: 'Registrasi Anggota'
          },
          {
            target: '/keanggotaan/laporan/profil-anggota',
            label: 'Profil Anggota'
          },
          {
            target: '/keanggotaan/laporan/saldo-anggota',
            label: 'Saldo Anggota'
          },
          {
            target: '/keanggotaan/laporan/anggota-keluar',
            label: 'Anggota Keluar'
          },
        ],
      },
    ]
  },
  // Tabungan
  {
    target: '/tabungan',
    label: 'Tabungan',
    icon: 'menu-icon fas fa-money-check-alt',
    children: [
      {
        target: '/tabungan/pembukaan-rekening-tabungan',
        label: 'Pembukaan Rekening Tabungan'
      },
      {
        target: '/tabungan/transaksi-tabungan',
        label: 'Transaksi Tabungan'
      },
      {
        target: '/tabungan/penutupan-rekening-tabungan',
        label: 'Penutupan Rekening Tabungan'
      },
      {
        target: '/tabungan/laporan',
        label: 'Laporan',
        children: [
          {
            target: '/tabungan/laporan/pembukaan-rekening-tabungan',
            label: 'Pembukaan Rekening Tabungan'
          },
          {
            target: '/tabungan/laporan/transaksi-tabungan',
            label: 'Transaksi Tabungan'
          },
          {
            target: '/tabungan/laporan/saldo-tabungan',
            label: 'Saldo Tabungan'
          },
          {
            target: '/tabungan/laporan/statement-tabungan',
            label: 'Statement Tabungan'
          },
          {
            target: '/tabungan/laporan/penutupan-rekening-tabungan',
            label: 'Penutupan Rekening Tabungan'
          },
        ],
      },
    ]
  },
  // Pembiayaan
  {
    target: '/pembiayaan',
    label: 'Pembiayaan',
    icon: 'menu-icon fas fa-wallet',
    children: [
      {
        target: '/pembiayaan/pengajuan-pembiayaan',
        label: 'Pengajuan Pembiayaan'
      },
      {
        target: '/pembiayaan/registrasi-akad',
        label: 'Registrasi Akad'
      },
      {
        target: '/pembiayaan/pencairan',
        label: 'Pencairan'
      },
      {
        target: '/pembiayaan/transaksi-pembiayaan',
        label: 'Transaksi Pembiayaan'
      },
      {
        target: '/pembiayaan/angsuran-pembiayaan',
        label: 'Angsuran Pembiayaan'
      },
      {
        target: '/pembiayaan/pelunasan-pembiayaan',
        label: 'Pelunasan Pembiayaan'
      },
      {
        target: '/pembiayaan/laporan',
        label: 'Laporan',
        children: [
          {
            target: '/pembiayaan/laporan/pengajuan-pembiayaan',
            label: 'Pengajuan Pembiayaan'
          },
          {
            target: '/pembiayaan/laporan/pencairan',
            label: 'Pencairan'
          },
          {
            target: '/pembiayaan/laporan/outstanding',
            label: 'Outstanding'
          },
          {
            target: '/pembiayaan/laporan/penerimaan-angsuran',
            label: 'Penerimaaan Angsuran'
          },
          {
            target: '/pembiayaan/laporan/kartu-angsuran',
            label: 'Kartu Angsuran'
          },
          {
            target: '/pembiayaan/laporan/pelunasan',
            label: 'Pelunasan'
          },
          {
            target: '/pembiayaan/laporan/kolektibilitas',
            label: 'Kolektibilitas'
          },
        ],
      },
    ]
  },
  // Keuangan
  {
    target: '/keuangan',
    label: 'Keuangan',
    icon: 'menu-icon fas fa-coins',
    children: [
      {
        target: '/keuangan/pengaturan-ledger',
        label: 'Pengaturan Ledger'
      },
      {
        target: '/keuangan/pengaturan-laporan-keuangan',
        label: 'Pengaturan Laporan Keuangan'
      },
      {
        target: '/keuangan/jurnal-transaksi',
        label: 'Jurnal Transaksi'
      },
      {
        target: '/keuangan/laporan',
        label: 'Laporan',
        children: [
          {
            target: '/keuangan/laporan/jurnal',
            label: 'Jurnal'
          },
          {
            target: '/keuangan/laporan/arus-kas',
            label: 'Arus Kas'
          },
          {
            target: '/keuangan/laporan/buku-besar',
            label: 'Buku Besar'
          },
          {
            target: '/keuangan/laporan/neraca-saldo',
            label: 'Neraca Saldo'
          },
          {
            target: '/keuangan/laporan/neraca',
            label: 'Neraca'
          },
          {
            target: '/keuangan/laporan/laba-rugi',
            label: 'Laba Rugi'
          },
        ],
      },
    ]
  },
  // Pengaturan
  {
    target: '/pengaturan',
    label: 'Pengaturan',
    icon: 'menu-icon fas fa-cogs',
    children: [
      {
        target: '/pengaturan/pengguna',
        label: 'Pengguna'
      },
      {
        target: '/pengaturan/grup-pengguna',
        label: 'Grup Pengguna'
      },
      {
        target: '/pengaturan/menu',
        label: 'Menu'
      },
      {
        target: '/pengaturan/lembaga',
        label: 'Lembaga'
      },
      {
        target: '/pengaturan/cabang',
        label: 'Cabang'
      },
      {
        target: '/pengaturan/wilayah',
        label: 'Wilayah'
      },
      {
        target: '/pengaturan/karyawan-petugas',
        label: 'Karyawan / Petugas'
      },
      {
        target: '/pengaturan/parameter',
        label: 'Parameter'
      },
      {
        target: '/pengaturan/tutup-periode',
        label: 'Tutup Periode'
      },
    ]
  },
]

export default menu