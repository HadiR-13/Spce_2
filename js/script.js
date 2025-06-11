document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".tab").forEach(tab => {
        tab.addEventListener("click", () => {
            document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
            document.querySelectorAll(".user_detail").forEach(detail => detail.style.display = "none");

            tab.classList.add("active");
            const target = tab.getAttribute("data-target");
            document.getElementById(target).style.display = "block";
        });
    });
});