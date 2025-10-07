// Navbar toggle
const navbarNav = document.querySelector(".navbar-nav");
document.querySelector("#hamburger-menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

document.addEventListener("click", (e) => {
  if (
    !document.querySelector("#hamburger-menu").contains(e.target) &&
    !navbarNav.contains(e.target)
  ) {
    navbarNav.classList.remove("active");
  }
});

// Modal order
const modal = document.querySelector("#orderModal");
const closeBtn = document.querySelector(".close");
const beliBtn = document.querySelector(".beli-btn");

beliBtn.addEventListener("click", () => (modal.style.display = "flex"));
closeBtn.addEventListener("click", () => (modal.style.display = "none"));
window.addEventListener("click", (e) => {
  if (e.target === modal) modal.style.display = "none";
});
