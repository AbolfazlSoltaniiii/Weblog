let onChangeThemeClick = () => {
    let titleDivide = document.querySelector('#titleDivide'),
        redirectButton = document.querySelector('#redirect'),
        themeToggleButton = document.querySelector('#themeToggle'),
        themeIcon = document.querySelector('#themeIcon');

    let currentTheme = document.body.getAttribute("data-bs-theme"),
        newTheme = currentTheme === "dark" ? "light" : "dark";

    document.body.setAttribute("data-bs-theme", newTheme);

    titleDivide.classList.remove("bg-dark", "bg-light");
    titleDivide.classList.add(newTheme === "dark" ? "bg-dark" : "bg-light");

    redirectButton.classList.remove("btn-outline-light", "btn-outline-dark");
    redirectButton.classList.add(newTheme === "dark" ? "btn-outline-light" : "btn-outline-dark");

    themeToggleButton.classList.remove("btn-outline-light", "btn-outline-dark");
    themeToggleButton.classList.add(newTheme === "dark" ? "btn-outline-light" : "btn-outline-dark");

    themeIcon.className = newTheme === "dark" ? "bi bi-sun-fill" : "bi bi-moon-fill";
}

let onRedirectClick = () => {
    window.location.href = '/';
}
