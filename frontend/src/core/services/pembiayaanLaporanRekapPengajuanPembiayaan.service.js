import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopsyahmsi.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-10-18
 */
export default {
  listReportRekapBy(payload, token) {
    let url = "laporan/list/get_rekap_by/" + payload;
    let config = {
      headers: {
        token: token,
      },
    };
    return axios.get(url, config);
  },
  listReportRekapPengajuan(payload, token) {
    const url = "laporan/rekap/pengajuan";
    const config = {
      headers: {
        token: token,
      },
    };
    return axios.post(url, payload, config);
  },
  listReportRekapPengajuanExportToXLSX(payload, token) {
    const url = "laporan/rekap/excel/pengajuan?" + payload;
    const config = {
      headers: {
        token: token,
      },
      responseType: "blob",
    };
    return axios.get(url, config);
  },
  listReportRekapPengajuanExportToCSV(payload, token) {
    const url = "laporan/rekap/csv/pengajuan?" + payload;
    const config = {
      headers: {
        token: token,
      },
      responseType: "blob",
    };
    return axios.get(url, config);
  },
};
