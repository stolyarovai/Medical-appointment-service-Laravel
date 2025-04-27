document.addEventListener("DOMContentLoaded", async () => {
    const container = document.getElementById("carousel-container");
    const prevBtn = document.getElementById("prev");
    const nextBtn = document.getElementById("next");

    const isLoggedIn = document.body.dataset.loggedIn === "true";

    let doctors = [];
    let currentIndex = 0;

    async function fetchDoctors() {
        const response = await fetch("/doctors/json");
        doctors = await response.json();
        if (doctors.length > 0) {
            currentIndex = 0;
            renderCarousel();
        } 
        else {
            container.innerHTML = "<p>Нет доступных врачей.</p>";
        }
    }

    function renderCarousel() {
        container.innerHTML = "";
        let visibleDoctors = [];

        for (let i = -1; i <= 1; i++) {
            let index = (currentIndex + i + doctors.length) % doctors.length;
            visibleDoctors.push(doctors[index]);
        }

        visibleDoctors.forEach(doctor => {
            const card = document.createElement("div");
            card.className = "doctor-card";
            card.innerHTML = `
                <img src="${doctor.profile_picture}" alt="${doctor.name}" class="doctor-img">
                <p class="doctor-name">${doctor.name}</p>
                <p class="doctor-specialty">${doctor.specialty}</p>
            `;

            if (isLoggedIn) {
                const link = document.createElement("a");
                link.href = `/appointment/${doctor.id}`;
                link.className = "appoint-doctor";
                link.textContent = "Записаться";
                card.appendChild(link);
            }

            container.appendChild(card);
        });
    }

    prevBtn.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + doctors.length) % doctors.length;
        renderCarousel();
    });

    nextBtn.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % doctors.length;
        renderCarousel();
    });

    fetchDoctors();
});
