const togglePasswordVisibility = () => {
    let passwordInput = document.getElementById('passwordInput'),
        passwordIcon = document.getElementById('passwordIcon');

    if (!passwordInput || !passwordIcon) return;

    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordIcon.classList.toggle('bi-eye');
    passwordIcon.classList.toggle('bi-eye-slash');
};

const validateInput = (input) => {
    input.value = input.value.replace(/[^a-zA-Z0-9_.@-]/g, '');
}
