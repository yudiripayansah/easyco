import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopsyahmsi.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-10-21
 */
export default {
    pembiayaanLaporanRekapPar(payload, token) {
        const url = "laporan/rekap/par";
        const config = {
            headers: {
                token: token,
            },
        };
        return axios.post(url, payload, config);
    },
    pembiayaanLaporanRekapParExportToXLSX(payload, token) {
        const url = "laporan/rekap/excel/par?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    },
    pembiayaanLaporanRekapParExportToCSV(payload, token) {
        const url = "laporan/rekap/csv/par?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    }
};