document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const submitButton = document.getElementById("submitButton");

    const loginField = document.getElementById("login");
    const passwordField = document.getElementById("password");

    const loginError = document.getElementById("loginError");
    const passwordError = document.getElementById("passwordError");
    const errorField = document.getElementById("Error");

    const loginRegex = /(^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$)|(^admin$)/;
    const passwordRegex = /^.{6,}$/;

    let isLoginValid = true;
    let isPasswordValid = true;

    function validateField(field, errorField, regex, errorMessage) {
        if (!field) return true;
        const value = field.value.trim();

        if (!regex.test(value)) {
            if (errorField) errorField.textContent = errorMessage;
            return false;
        } 
        else {
            if (errorField) errorField.textContent = "";
            return true;
        }
    }

    function toggleSubmitButton() {
        if (submitButton) {
            submitButton.disabled = !(isLoginValid && isPasswordValid);
        }
    }

    if (loginField && loginError) {
        loginField.addEventListener("input", () => {
            isLoginValid = validateField(
                loginField,
                loginError,
                loginRegex,
                "Введите корректный логин"
            );
            toggleSubmitButton();
        });
    }

    if (passwordField && passwordError) {
        passwordField.addEventListener("input", () => {
            isPasswordValid = validateField(
                passwordField,
                passwordError,
                passwordRegex,
                "Пароль должен содержать минимум 6 символов"
            );
            toggleSubmitButton();
        });
    }

    if (form) {
        form.addEventListener("submit", (event) => {
            event.preventDefault();

            if (isLoginValid && isPasswordValid) {
                const formData = new FormData(form);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(form.action, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect_from;
                        } 
                        else {
                            if (errorField) {
                                errorField.textContent = data.error || "Ошибка авторизации";
                            }
                        }
                    })
                    .catch(() => {
                        if (errorField) {
                            errorField.textContent = "Ошибка соединения с сервером";
                        }
                    });
                }
        });
    }
});