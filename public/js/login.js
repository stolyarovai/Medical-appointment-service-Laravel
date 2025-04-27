document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const emailField = document.getElementById("email");
    const passwordField = document.getElementById("password");
    const errorField = document.getElementById("loginError");
    const submitButton = document.getElementById("submitButton");

    let isLoginValid = false;
    let isPasswordValid = false;

    if (emailField) {
        emailField.addEventListener("input", () => {
            validateLogin();
            toggleSubmitButton();
        });
    }

    if (passwordField) {
        passwordField.addEventListener("input", () => {
            validatePassword();
            toggleSubmitButton();
        });
    }

    function validateLogin() {
        const email = emailField.value.trim();
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/;
        
        if (!emailRegex.test(email)) {
            if (errorField) {
                errorField.textContent = "Введите корректный e-mail";
            }
            isLoginValid = false;
            return;
        }
        
        if (errorField) {
            errorField.textContent = "";
        }
        isLoginValid = true;
    }

    function validatePassword() {
        const password = passwordField.value.trim();
        
        if (password.length < 6) {
            if (errorField) {
                errorField.textContent = "Пароль должен быть не менее 6 символов";
            }
            isPasswordValid = false;
            return;
        }
        
        if (errorField) {
            errorField.textContent = "";
        }
        isPasswordValid = true;
    }

    function toggleSubmitButton() {
        if (submitButton) {
            submitButton.disabled = !(isLoginValid && isPasswordValid);
        }
    }

    if (form) {
        form.addEventListener("submit", (event) => {
            event.preventDefault();

            if (isLoginValid && isPasswordValid) {
                const formData = new FormData(form);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                if (errorField) {
                    errorField.textContent = "Выполняется вход...";
                }
                
                fetch(form.action, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok && response.status !== 401) {
                        throw new Error('Ошибка сервера');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (errorField) {
                            errorField.textContent = "Вход выполнен успешно. Перенаправление...";
                            errorField.style.color = "green";
                        }
                        
                        setTimeout(() => {
                            window.location.href = data.redirect_from;
                        }, 500);
                    } else {
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