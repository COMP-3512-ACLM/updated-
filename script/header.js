document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("#menu").addEventListener("click", e => {
        document.querySelector("header nav").classList.toggle("active");
    });
});