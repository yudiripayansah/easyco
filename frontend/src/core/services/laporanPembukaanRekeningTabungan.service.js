import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopsyahmsi.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-09-23
 */
export default {
  listReportPembukaanRekeningTabungan(payload, token) {
    const url = "laporan/list/buka_tabungan";
    const config = {
      headers: {
        token: token,
      },
    };
    return axios.post(url, payload, config);
  },
  listReportPembukaanRekeningTabunganExportToXLSX(payload, token) {
    const url = "laporan/list/excel/buka_tabungan?" + payload;
    const config = {
      headers: {
        token: token,
      },
      responseType: "blob",
    };
    return axios.get(url, config);
  },
  listReportPembukaanRekeningTabunganExportToCSV(payload, token) {
    const url = "laporan/list/csv/buka_tabungan?" + payload;
    const config = {
      headers: {
        token: token,
      },
      responseType: "blob",
    };
    return axios.get(url, config);
  },
};
