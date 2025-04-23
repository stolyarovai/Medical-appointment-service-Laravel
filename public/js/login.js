document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const submitButton = document.getElementById("submitButton");

    const loginField = document.getElementById("login");
    const passwordField = document.getElementById("password");

    const loginError = document.getElementById("loginError");
    const passwordError = document.getElementById("passwordError");
    const errorField = document.getElementById("Error");

    const loginRegex = /(^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$)|(^admin$)/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z]).{6,}$/;

    let isLoginValid = false;
    let isPasswordValid = false;

    function validateField(field, errorField, regex, errorMessage) {
        const value = field.value.trim();

        if (!regex.test(value)) {
            errorField.textContent = errorMessage;
            return false;
        } 
        else {
            errorField.textContent = "";
            return true;
        }
    }

    function toggleSubmitButton() {
        submitButton.disabled = !(isLoginValid && isPasswordValid);
    }

    loginField.addEventListener("input", () => {
        isLoginValid = validateField(
            loginField,
            loginError,
            loginRegex,
            "Введите корректный логин"
        );
        toggleSubmitButton();
    });

    passwordField.addEventListener("input", () => {
        isPasswordValid = validateField(
            passwordField,
            passwordError,
            passwordRegex,
            "Пароль должен содержать минимум 6 символов с буквами разного регистра"
        );
        toggleSubmitButton();
    });

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        if (isLoginValid && isPasswordValid) {
            const formData = new FormData(form);

            fetch("../actions/authorize.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect_from;
                    } 
                    else {
                        errorField.textContent = data.error || "Ошибка авторизации";
                    }
                })
                .catch(() => {
                    errorField.textContent = "Ошибка соединения с сервером";
                });
            }
    });
});