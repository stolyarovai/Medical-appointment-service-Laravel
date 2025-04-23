document.addEventListener("DOMContentLoaded", () => {
    const dateInput = document.querySelector("input[name='date']");
    const timeContainer = document.querySelector(".time-container");

    dateInput.addEventListener("change", async () => {
        const doctorId = document.querySelector("input[type='hidden']").value;
        const date = dateInput.value;

        if (!date) {
            return;
        }

        const response = await fetch(`/servis/actions/get_appointments.php?date=${date}&doctor_id=${doctorId}`);
        const data = await response.json();

        if (!data.success) {
            timeContainer.innerHTML = `<p class="text_message">Ошибка загрузки</p>`;
            return;
        }

        timeContainer.innerHTML = "";

        const bookedTimes = new Set(data.booked);
        const allTimes = data.available.concat(data.booked).sort((a, b) => {
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
                button.addEventListener("click", () => confirmAppointment(doctorId, date, time));
            }

            timeContainer.appendChild(button);
        });
    });
});

function confirmAppointment(doctorId, date, time) {
    if (!confirm(`Записаться на ${date} в ${time}?`)) {
        return;
    }

    fetch("/servis/actions/appoint.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ doctor_id: doctorId, appointment_date: date, appointment_time: time })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } 
        else {
            alert("Ошибка: " + data.error);
        }
    });
}