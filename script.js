const button = document.querySelector("#theme-toggle");
const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");

button.addEventListener("click", function () {
    if (prefersDarkScheme.matches) {
        document.body.classList.toggle("light-mode");
        console.log(document.body.classList);
        var theme = document.body.classList.contains("light-mode") ? "light" : "dark";
    } else {
        document.body.classList.toggle("dark-mode");
        var theme = document.body.classList.contains("dark-mode") ? "dark" : "light";
    }
    document.cookie = "theme=" + theme;
});
