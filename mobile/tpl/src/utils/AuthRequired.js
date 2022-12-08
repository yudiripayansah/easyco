export default (to, from, next) => {
  if (localStorage.getItem('easycoTpl') != null && localStorage.getItem('easycoTpl').length > 0) {
    next()
  } else {
    localStorage.removeItem('easycoTpl')
    next('/login')
  }
}
