// const body = document.querySelector("body"),
//    sidebar = body.querySelector(".sidebar"),
//    toggle = body.querySelector(".toggle");

//    toggle.addEventListener("click", () =>{
//       sidebar.classList.toggle("close");
//    });

  document.addEventListener("DOMContentLoaded", () => {
        const sidebar = document.querySelector(".sidebar");
        const toggle = document.querySelector(".toggle");

        // Check localStorage for saved state
        const isSidebarOpen = localStorage.getItem("sidebar-open");

        if (isSidebarOpen === "true") {
            sidebar.classList.remove("close");
        } else {
            sidebar.classList.add("close");
        }

        // Toggle sidebar on click and save state
        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");

            // Save the new state
            const isOpen = !sidebar.classList.contains("close");
            localStorage.setItem("sidebar-open", isOpen);
        });
    });