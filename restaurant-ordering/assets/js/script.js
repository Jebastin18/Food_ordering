// Show toast messages
document.addEventListener("DOMContentLoaded", () => {
  // Bootstrap toast initialization
  const bootstrap = window.bootstrap
  var toastElList = [].slice.call(document.querySelectorAll(".toast"))
  var toastList = toastElList.map((toastEl) => new bootstrap.Toast(toastEl))

  // Show all toasts
  toastList.forEach((toast) => toast.show())
})
