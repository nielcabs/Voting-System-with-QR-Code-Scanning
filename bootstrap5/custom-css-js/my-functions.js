window.addEventListener("DOMContentLoaded", (event) => {
  const sidebarToggle = document.body.querySelector("#sidebarToggle");
  if (sidebarToggle) {
    sidebarToggle.addEventListener("click", (event) => {
      event.preventDefault();
      document.body.classList.toggle("sidebar-toggled");
      localStorage.setItem(
        "sidebar|sidebar-toggle",
        document.body.classList.contains("sidebar-toggled")
      );
    });
  }
});
