import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopsyahmsi.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-10-21
 */
export default {
    pembiayaanLaporanRekapOutstandingPiutang(payload, token) {
        const url = "laporan/rekap/outstanding";
        const config = {
            headers: {
                token: token,
            },
        };
        return axios.post(url, payload, config);
    },
    pembiayaanLaporanRekapOutstandingPiutangExportToXLSX(payload, token) {
        const url = "laporan/rekap/excel/outstanding?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    },
    pembiayaanLaporanRekapOutstandingPiutangExportToCSV(payload, token) {
        const url = "laporan/rekap/csv/outstanding?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    }
};