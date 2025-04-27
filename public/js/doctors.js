document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("newDoctor");
    const doctorsList = document.getElementById("doctorsList");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const fullNameField = document.getElementById("fullName");
    const specialityField = document.getElementById("speciality");
    const profilePictureField = document.getElementById("profilePicture");

    const fullNameError = document.getElementById("fullNameError");
    const specialityError = document.getElementById("specialityError");
    const profilePictureError = document.getElementById("profilePictureError");
    const generalError = document.getElementById("Error");

    function displayError(field, message) {
        if (field) field.textContent = message;
    }

    if (form) {
        form.addEventListener("submit", async (event) => {
            event.preventDefault();

            const errorFields = [fullNameError, specialityError, profilePictureError, generalError];
            errorFields.forEach((field) => {
                if (field) displayError(field, "");
            });

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData,
                });

                const data = await response.json();

                if (data.success) {
                    if (data.html) {
                        if (doctorsList) {
                            doctorsList.insertAdjacentHTML('beforeend', data.html);
                            form.reset();
                        } else {
                            location.reload();
                        }
                    } else {
                        location.reload();
                    }
                } 
                else {
                    displayError(generalError, data.error || "Ошибка добавления врача.");
                }
            } 
            catch (error) {
                displayError(generalError, "Произошла ошибка. Попробуйте позже.");
            }
        });
    }

    document.addEventListener('click', async function(e) {
        if (e.target && e.target.classList.contains('delete-doctor')) {
            const doctorId = e.target.getAttribute("data-id");
            
            if (confirm("Вы уверены, что хотите удалить этого врача?")) {
                try {
                    const response = await fetch(`/doctors/${doctorId}`, {
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        const doctorItem = document.querySelector(`.doctor-item[data-id="${doctorId}"]`);
                        if (doctorItem) doctorItem.remove();
                    } 
                    else {
                        alert("Ошибка при удалении врача.");
                    }
                } 
                catch (error) {
                    alert("Произошла ошибка. Попробуйте позже.");
                }
            }
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('profile-picture')) {
            const doctorItem = e.target.closest(".doctor-item");
            if (!doctorItem) return;
            
            const doctorId = doctorItem.getAttribute("data-id");
            const fileInput = document.createElement("input");
            fileInput.type = "file";
            fileInput.accept = "image/*";

            fileInput.addEventListener("change", () => {
                const file = fileInput.files[0];
                if (file) {
                    const formData = new FormData();
                    formData.append("profilePicture", file);

                    fetch(`/doctors/${doctorId}/icon`, {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            e.target.src = data.newProfilePicture;
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
        }
    });
}); 