import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopsyahmsi.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-09-22
 */
export default {
    getReportSetup(payload, token) {
        let url = "laporan/list/get_report_setup?" + payload;
        let config = {
            headers: {
                token: token,
            },
        };
        return axios.get(url, config);
    }
}