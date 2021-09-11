import axios from 'axios'
// const baseURL = 'http://localhost:8000/api/'
const baseURL = 'https://labpcrapi.hseswadaya.co.id/api/'
export default axios.create({
  baseURL
  // You can add your headers here
})