import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopsyahmsi.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-09-15
 */
export default {
    getRekeningTabungan(payload, token) {
        const url = "tabungan/get_rekening";
        const config = {
            headers: {
                token: token,
            },
        };
        return axios.post(url, payload, config);
    },
    listStatementTabungan(payload, token) {
        const url = "laporan/list/statement_tabungan";
        const config = {
            headers: {
                token: token,
            },
        };
        return axios.post(url, payload, config);
    },
    listStatementTabunganExportToXLSX(payload, token) {
        const url = "laporan/list/excel/statement_tabungan?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    },
    listStatementTabunganExportToCSV(payload, token) {
        const url = "laporan/list/csv/statement_tabungan?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    }
}