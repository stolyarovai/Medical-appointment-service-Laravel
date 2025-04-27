document.addEventListener("DOMContentLoaded", () => {
    const dateInput = document.querySelector("input[name='date']");
    const timeContainer = document.querySelector(".time-container");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (dateInput) {
        dateInput.addEventListener("change", async () => {
            const doctorId = document.querySelector("input[name='doctor_id']").value;
            const date = dateInput.value;

            if (!date) {
                return;
            }

            try {
                const response = await fetch(`/appointments/availability?doctor_id=${doctorId}&date=${date}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();

                if (!data.success) {
                    if (timeContainer) {
                        timeContainer.innerHTML = `<p class="text_message">Ошибка загрузки</p>`;
                    }
                    return;
                }

                if (timeContainer) {
                    timeContainer.innerHTML = "";

                    const bookedTimes = new Set(data.booked);
                    const allTimes = [...data.available, ...data.booked].sort((a, b) => {
                        const timeA = a.split(":").map(Number);
                        const timeB = b.split(":").map(Number);
                        return timeA[0] - timeB[0] || timeA[1] - timeB[1];
                    });

                    allTimes.forEach(time => {
                        const button = document.createElement("button");
                        button.classList.add("time-button");
                        button.textContent = time;
                        button.dataset.time = time;
                        
                        if (bookedTimes.has(time)) {
                            button.disabled = true;
                            button.classList.add("booked");
                        } 
                        else {
                            button.addEventListener("click", () => confirmAppointment(doctorId, date, time, csrfToken));
                        }

                        timeContainer.appendChild(button);
                    });
                }
            } catch (error) {
                console.error("Ошибка при загрузке времени:", error);
                if (timeContainer) {
                    timeContainer.innerHTML = `<p class="text_message">Ошибка загрузки</p>`;
                }
            }
        });
    }
});

function confirmAppointment(doctorId, date, time, csrfToken) {
    if (!confirm(`Записаться на ${date} в ${time}?`)) {
        return;
    }

    const formData = new FormData();
    formData.append('doctor_id', doctorId);
    formData.append('appointment_date', date);
    formData.append('appointment_time', time);

    fetch("/appointments", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect_from;
        } 
        else {
            alert("Ошибка: " + (data.error || "Не удалось создать запись"));
        }
    })
    .catch(error => {
        console.error("Ошибка при создании записи:", error);
        alert("Произошла ошибка при создании записи");
    });
}