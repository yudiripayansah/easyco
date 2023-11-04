import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopikoding.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-11-04
 */
export default {
    getDetailSaving(payload, token) {
        const url = "laporan/list/get_detail_saving?" + payload;
        const config = {
            headers: {
                token: token,
            },
            responseType: 'blob'
        };
        return axios.post(url, config);
    },
    trxRembugProcessPinbukSimsuk(payload, token) {
        const url = "trx_rembug/proses_pinbuk_simsuk";
        const config = {
            headers: {
                token: token,
            },
        };
        return axios.post(url, payload, config);
    },
};