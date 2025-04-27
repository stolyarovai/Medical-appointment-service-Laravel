document.addEventListener("DOMContentLoaded", async () => {
    const container = document.getElementById("carousel-container");
    const prevBtn = document.getElementById("prev");
    const nextBtn = document.getElementById("next");

    const isLoggedIn = document.body.dataset.loggedIn === "true";

    let doctors = [];
    let currentIndex = 0;
    let isAnimating = false;

    async function fetchDoctors() {
        try {
            const response = await fetch("/doctors/json");
            doctors = await response.json();
            
            if (doctors.length > 0) {
                currentIndex = 0;
                renderCarousel();
            } 
            else {
                container.innerHTML = '<div class="alert alert-info">Нет доступных врачей.</div>';
            }
        } catch (error) {
            console.error("Ошибка при загрузке данных:", error);
            container.innerHTML = '<div class="alert alert-danger">Не удалось загрузить данные о врачах.</div>';
        }
    }

    function renderCarousel() {
        container.innerHTML = "";
        let visibleDoctors = [];

        const itemsToShow = window.innerWidth > 768 ? 3 : 1;
        
        for (let i = 0; i < itemsToShow; i++) {
            let index = (currentIndex + i) % doctors.length;
            visibleDoctors.push(doctors[index]);
        }

        visibleDoctors.forEach(doctor => {
            const card = document.createElement("div");
            card.className = "doctor-card";
            
            const imgSrc = doctor.profile_picture || 'https://via.placeholder.com/130x130?text=Фото';
            
            card.innerHTML = `
                <div class="doctor-info">
                    <img src="${imgSrc}" alt="${doctor.name}" class="doctor-img">
                    <p class="doctor-name">${doctor.name}</p>
                    <p class="doctor-specialty">${doctor.specialty}</p>
                </div>
            `;

            if (isLoggedIn) {
                const linkContainer = document.createElement("div");
                linkContainer.className = "mt-3";
                
                const link = document.createElement("a");
                link.href = `/appointment/${doctor.id}`;
                link.className = "appoint-doctor";
                link.textContent = "Записаться";
                
                linkContainer.appendChild(link);
                card.appendChild(linkContainer);
            }

            container.appendChild(card);
        });
    }

    prevBtn.addEventListener("click", () => {
        if (isAnimating) return;
        
        isAnimating = true;
        container.style.opacity = '0';
        
        setTimeout(() => {
            currentIndex = (currentIndex - 1 + doctors.length) % doctors.length;
            renderCarousel();
            container.style.opacity = '1';
            isAnimating = false;
        }, 300);
    });

    nextBtn.addEventListener("click", () => {
        if (isAnimating) return;
        
        isAnimating = true;
        container.style.opacity = '0';
        
        setTimeout(() => {
            currentIndex = (currentIndex + 1) % doctors.length;
            renderCarousel();
            container.style.opacity = '1';
            isAnimating = false;
        }, 300);
    });

    window.addEventListener("resize", () => {
        renderCarousel();
    });

    fetchDoctors();
});
