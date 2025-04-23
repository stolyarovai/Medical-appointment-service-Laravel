document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("newDoctor");
    const doctorsList = document.getElementById("doctorsList");

    const fullNameField = document.getElementById("fullName");
    const specialityField = document.getElementById("speciality");
    const profilePictureField = document.getElementById("profilePicture");

    const fullNameError = document.getElementById("fullNameError");
    const specialityError = document.getElementById("specialityError");
    const profilePictureError = document.getElementById("profilePictureError");
    const generalError = document.getElementById("Error");

    function displayError(field, message) {
        field.textContent = message;
    }

    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        [fullNameError, specialityError, profilePictureError, generalError].forEach((field) => {
            displayError(field, "");
        });

        const formData = new FormData();
        formData.append("fullName", fullNameField.value.trim());
        formData.append("speciality", specialityField.value.trim());
        if (profilePictureField.files[0]) {
            formData.append("profilePicture", profilePictureField.files[0]);
        }

        try {
            const response = await fetch("../actions/add_doctor.php", {
                method: "POST",
                body: formData,
            });

            const data = await response.json();

            if (data.success) {
                location.reload();
            } 
            else {
                displayError(generalError, data.error || "Ошибка добавления врача.");
            }
        } 
        catch (error) {
            displayError(generalError, "Произошла ошибка. Попробуйте позже.");
        }
    });

    const deleteDoctorButtons = document.querySelectorAll(".-doctor");

    deleteDoctorButtons.forEach(button => {
        button.addEventListener("click", async () => {
            const doctorId = button.getAttribute("data-id");

            if (confirm("Вы уверены, что хотите удалить этого врача?")) {
                try {
                    const response = await fetch("../actions/delete_doctor.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ id: doctorId })
                    });

                    const data = await response.json();

                    if (data.success) {
                        const doctorItem = document.querySelector(`.doctor-item[data-id="${doctorId}"]`);
                        doctorItem.remove();
                    } 
                    else {
                        alert("Ошибка при удалении врача.");
                    }
                } 
                catch (error) {
                    alert("Произошла ошибка. Попробуйте позже.");
                }
            }
        });
    });

    const avatarElements = document.querySelectorAll(".profile-picture");

    avatarElements.forEach(img => {
        img.addEventListener("click", () => {
            const doctorId = img.closest(".doctor-item").getAttribute("data-id");
            const fileInput = document.createElement("input");
            fileInput.type = "file";
            fileInput.accept = "image/*";

            fileInput.addEventListener("change", () => {
                const file = fileInput.files[0];
                if (file) {
                    const formData = new FormData();
                    formData.append("doctorId", doctorId);
                    formData.append("profilePicture", file);

                    fetch("../actions/alter_icon.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            img.src = `/servis/profile_pictures/${data.newProfilePicture}`;
                        } 
                        else {
                            alert("Ошибка при изменении фото.");
                        }
                    })
                    .catch(() => {
                        alert("Произошла ошибка. Попробуйте позже.");
                    });
                }
            });

            fileInput.click();
        });
    });
});