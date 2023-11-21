import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopsyahmsi.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-09-23
 */
export default {
    listReportPelunasanPembiayaan(payload, token) {
        const url = "laporan/list/pelunasan";
        const config = {
            headers: {
                token: token,
            },
        };
        return axios.post(url, payload, config);
    },
    listReportPelunasanPembiayaanExportToXLSX(payload, token) {
        const url = "laporan/list/excel/pelunasan?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    },
    listReportPelunasanPembiayaanExportToCSV(payload, token) {
        const url = "laporan/list/csv/pelunasan?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    }
}