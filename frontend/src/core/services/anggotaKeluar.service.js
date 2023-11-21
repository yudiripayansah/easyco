import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopsyahmsi.comm/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-09-11
 */
const easycoApi = {
    listAnggotaKeluar(payload, token) {
        const url = "laporan/list/anggota_keluar";
        const config = {
            headers: {
                token: token,
            },
        };
        return axios.post(url, payload, config);
    },
    listAnggotaKeluarExportToXLSX(payload, token) {
        const url = "laporan/list/excel/anggota_keluar?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    },
    listAnggotaKeluarExportToCSV(payload, token) {
        const url = "laporan/list/csv/anggota_keluar?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.get(url, config);
    }
};
export default easycoApi;