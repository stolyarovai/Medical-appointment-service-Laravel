document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const genderText = document.getElementById("gender-text");
    const editGenderBtn = document.getElementById("edit-gender-btn");

    if (editGenderBtn && genderText) {
        editGenderBtn.addEventListener("click", () => {
            const select = document.createElement("select");
            select.innerHTML = `
                <option value="male" ${genderText.innerText === "Мужской" ? "selected" : ""}>Мужской</option>
                <option value="female" ${genderText.innerText === "Женский" ? "selected" : ""}>Женский</option>
                <option value="undetermined" ${genderText.innerText === "Не указан" ? "selected" : ""}>Не указан</option>
            `;

            const saveBtn = document.createElement("button");
            saveBtn.innerText = "Готово";
            const cancelBtn = document.createElement("button");
            cancelBtn.innerText = "Отмена";

            genderText.replaceWith(select);
            editGenderBtn.replaceWith(saveBtn);
            saveBtn.after(cancelBtn);

            cancelBtn.addEventListener("click", () => {
                select.replaceWith(genderText);
                saveBtn.replaceWith(editGenderBtn);
                cancelBtn.remove();
            });

            saveBtn.addEventListener("click", async () => {
                const newGender = select.value;
                const formData = new FormData();
                formData.append("field", "gender");
                formData.append("value", newGender);

                try {
                    const response = await fetch("/profile/update", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });
                    const result = await response.json();

                    if (result.success) {
                        window.location.reload();
                    } else {
                        alert(result.error || "Ошибка при обновлении профиля");
                    }
                } catch (error) {
                    console.error("Ошибка при обновлении профиля:", error);
                    alert("Произошла ошибка при обновлении профиля");
                }
            });
        });
    }

    const birthDateText = document.getElementById("birth-date-text");
    const editBirthDateBtn = document.getElementById("edit-birth-date-btn");

    if (editBirthDateBtn && birthDateText) {
        editBirthDateBtn.addEventListener("click", () => {
            const input = document.createElement("input");
            input.type = "date";
            input.value = birthDateText.dataset.date || '';

            const saveBtn = document.createElement("button");
            saveBtn.innerText = "Готово";
            const cancelBtn = document.createElement("button");
            cancelBtn.innerText = "Отмена";

            birthDateText.replaceWith(input);
            editBirthDateBtn.replaceWith(saveBtn);
            saveBtn.after(cancelBtn);

            cancelBtn.addEventListener("click", () => {
                input.replaceWith(birthDateText);
                saveBtn.replaceWith(editBirthDateBtn);
                cancelBtn.remove();
            });

            saveBtn.addEventListener("click", async () => {
                const newBirthDate = input.value;

                const formData = new FormData();
                formData.append("field", "birth_date");
                formData.append("value", newBirthDate);

                try {
                    const response = await fetch("/profile/update", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });
                    const result = await response.json();

                    if (result.success) {
                        window.location.reload();
                    } else {
                        alert(result.error || "Ошибка при обновлении профиля");
                    }
                } catch (error) {
                    console.error("Ошибка при обновлении профиля:", error);
                    alert("Произошла ошибка при обновлении профиля");
                }
            });
        });
    }

    document.querySelectorAll(".cancel-btn").forEach(button => {
        button.addEventListener("click", async function() {
            const appointmentId = this.getAttribute("data-id");
            
            if (!confirm("Вы уверены, что хотите отменить запись?")) {
                return;
            }

            const formData = new FormData();
            formData.append("appointment_id", appointmentId);

            try {
                const response = await fetch("/dashboard/cancel", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    window.location.reload();
                } else {
                    alert(result.error || "Ошибка при отмене записи");
                }
            } catch (error) {
                console.error("Ошибка при отмене записи:", error);
                alert("Произошла ошибка при отмене записи");
            }
        });
    });
});
