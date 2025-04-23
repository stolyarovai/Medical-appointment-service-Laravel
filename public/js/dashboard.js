document.addEventListener("DOMContentLoaded", () => {
    const genderText = document.getElementById("gender-text");
    const editGenderBtn = document.getElementById("edit-gender-btn");

    editGenderBtn.addEventListener("click", () => {
        const select = document.createElement("select");
        select.innerHTML = `
            <option value="male" ${genderText.innerText === "Мужской" ? "selected disabled" : ""}>Мужской</option>
            <option value="female" ${genderText.innerText === "Женский" ? "selected disabled" : ""}>Женский</option>
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

            const response = await fetch("/servis/actions/update_profile.php", {
                method: "POST",
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                window.location.reload();
            } 
            else {
                alert(result.error);
            }
        });
    });

    const birthDateText = document.getElementById("birth-date-text");
    const editBirthDateBtn = document.getElementById("edit-birth-date-btn");

    editBirthDateBtn.addEventListener("click", () => {
        const input = document.createElement("input");
        input.type = "date";
        input.value = birthDateText.dataset.date;

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

            const response = await fetch("/servis/actions/update_profile.php", {
                method: "POST",
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                window.location.reload();
            } 
            else {
                alert(result.error);
            }
        });
    });

    document.querySelectorAll(".cancel-btn").forEach(button => {
        button.addEventListener("click", async function () {
            const appointmentId = this.getAttribute("data-id");

            const formData = new FormData();
            formData.append("cancel_appointment_id", appointmentId);

            const response = await fetch("/servis/pages/dashboard.php", {
                method: "POST",
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                window.location.reload();
            } 
            else {
                alert(result.error);
            }
        });
    });
});
