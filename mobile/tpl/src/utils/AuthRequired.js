export default (to, from, next) => {
  if (localStorage.getItem('baikTpl') != null && localStorage.getItem('baikTpl').length > 0) {
    next()
  } else {
    localStorage.removeItem('baikTpl')
    next('/login')
  }
}
