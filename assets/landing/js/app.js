document.addEventListener("DOMContentLoaded", function () {
  window.onscroll = function () {
    let navbar = document.querySelector("nav.navbar");
    if (
      document.body.scrollTop > 50 ||
      document.documentElement.scrollTop > 50
    ) {
      navbar.classList.add("bg-white", "fixed-top");
    } else {
      navbar.classList.remove("bg-white", "fixed-top");
    }
  };
});
