import axios from "axios";
axios.defaults.baseURL = "https://easyco.kopsyahmsi.com/api/api/";

/**
 * BEGIN
 * @author Irham C. <icip1998@gmail.com>
 * @date 2023-10-17
 */
export default {
  listReportSaldoKasPetugas(payload, token) {
    const url = "laporan/list/saldo_kas_petugas";
    const config = {
      headers: {
        token: token,
      },
    };
    return axios.post(url, payload, config);
  },
  listReportSaldoKasPetugasExportToXLSX(payload, token) {
    const url = "laporan/list/excel/saldo_kas_petugas?" + payload;
    const config = {
      headers: {
        token: token,
      },
      responseType: "blob",
    };
    return axios.get(url, config);
  },
  listReportSaldoKasPetugasExportToCSV(payload, token) {
    const url = "laporan/list/csv/saldo_kas_petugas?" + payload;
    const config = {
      headers: {
        token: token,
      },
      responseType: "blob",
    };
    return axios.get(url, config);
  },
};
