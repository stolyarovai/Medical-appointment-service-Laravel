document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registrationForm");
    const submitButton = document.getElementById("submitButton");

    const fullNameField = document.getElementById("fullName");
    const emailField = document.getElementById("email");
    const passwordField = document.getElementById("password");
    const confirmPasswordField = document.getElementById("confirmPassword");

    const fullNameError = document.getElementById("fullNameError");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");

    const fullNameRegex = /^[А-ЯЁа-яё]+ [А-ЯЁа-яё]+ [А-ЯЁа-яё]+$/;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z]).{6,}$/;

    let isFullNameValid = false;
    let isEmailValid = false;
    let isPasswordValid = false;
    let isConfirmPasswordValid = false;

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

    function validateEmailUniqueness(email, callback) {
        fetch("../actions/validate.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "email=" + encodeURIComponent(email),
        })
            .then(response => response.json())
            .then(data => {
                isEmailValid = !data.exists;
                emailError.textContent = data.exists ? "Этот email уже занят" : "";
                callback();
            })
            .catch(() => {
                isEmailValid = false;
                emailError.textContent = "Ошибка проверки email";
                callback();
            });
    }

    function toggleSubmitButton() {
        submitButton.disabled = !(isFullNameValid && isEmailValid && isPasswordValid && isConfirmPasswordValid);
    }

    function validateAllFields() {
        isFullNameValid = validateField(
            fullNameField,
            fullNameError,
            fullNameRegex,
            "Должно содержать только кириллицу и пробелы"
        );

        isPasswordValid = validateField(
            passwordField,
            passwordError,
            passwordRegex,
            "Должно быть минимум 6 английских букв разного регистра"
        );

        isConfirmPasswordValid = passwordField.value === confirmPasswordField.value;
        confirmPasswordError.textContent = isConfirmPasswordValid ? "" : "Пароли не совпадают";

        if (validateField(emailField, emailError, emailRegex, "Введите корректный e-mail")) {
            validateEmailUniqueness(emailField.value, toggleSubmitButton);
        } 
        else {
            isEmailValid = false;
            toggleSubmitButton();
        }
    }

    fullNameField.addEventListener("input", () => {
        isFullNameValid = validateField(
            fullNameField,
            fullNameError,
            fullNameRegex,
            "Должно содержать только кириллицу и пробелы"
        );
        toggleSubmitButton();
    });

    emailField.addEventListener("input", () => {
        if (validateField(emailField, emailError, emailRegex, "Введите корректный e-mail")) {
            validateEmailUniqueness(emailField.value, toggleSubmitButton);
        } 
        else {
            isEmailValid = false;
            toggleSubmitButton();
        }
    });

    passwordField.addEventListener("input", () => {
        isPasswordValid = validateField(
            passwordField,
            passwordError,
            passwordRegex,
            "Должно быть минимум 6 английских букв разного регистра"
        );
        toggleSubmitButton();
    });

    confirmPasswordField.addEventListener("input", () => {
        isConfirmPasswordValid = passwordField.value === confirmPasswordField.value;
        confirmPasswordError.textContent = isConfirmPasswordValid ? "" : "Пароли не совпадают";
        toggleSubmitButton();
    });

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        validateAllFields();
        if (isFullNameValid && isEmailValid && isPasswordValid && isConfirmPasswordValid) {
            form.submit();
        }
    });
});