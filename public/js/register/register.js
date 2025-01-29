const toggleVisibility = (inputId, iconId) => {
    let input = document.getElementById(inputId),
        icon = document.getElementById(iconId);

    if (!input || !icon) return;

    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    icon.classList.toggle('bi-eye', !isPassword);
    icon.classList.toggle('bi-eye-slash', isPassword);
};
