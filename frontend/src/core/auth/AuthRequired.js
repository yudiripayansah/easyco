export default (to, from, next) => {
  if (localStorage.getItem('HseAdmUser') != null) {
    next()
  } else {
    localStorage.removeItem('HseAdmUser')
    next('/login')
  }
}
