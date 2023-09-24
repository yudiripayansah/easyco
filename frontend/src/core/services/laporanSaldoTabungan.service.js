import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopikoding.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-09-23
 */
export default {
    listReportSaldoTabungan(payload, token) {
        const url = "laporan/list/saldo_tabungan";
        const config = {
            headers: {
                token: token,
            },
        };
        return axios.post(url, payload, config);
    },
    listReportSaldoTabunganExportToXLSX(payload, token) {
        const url = "laporan/list/excel/saldo_tabungan?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    },
    listReportSaldoTabunganExportToCSV(payload, token) {
        const url = "laporan/list/csv/saldo_tabungan?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    }
};