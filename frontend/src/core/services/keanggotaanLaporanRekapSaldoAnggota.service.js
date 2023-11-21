import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopsyahmsi.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-10-21
 */
export default {
    laporanRekapSaldoAnggota(payload, token) {
        const url = "laporan/rekap/saldo_anggota";
        const config = {
            headers: {
                token: token,
            },
        };
        return axios.post(url, payload, config);
    },
    laporanRekapSaldoAnggotaExportToXLSX(payload, token) {
        const url = "laporan/rekap/excel/saldo_anggota?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    },
    laporanRekapSaldoAnggotaExportToCSV(payload, token) {
        const url = "laporan/rekap/csv/saldo_anggota?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    }
};