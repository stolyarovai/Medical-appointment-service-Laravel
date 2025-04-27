document.addEventListener("DOMContentLoaded", () => {
    const deleteAllButton = document.getElementById("deleteAllButton");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (deleteAllButton) {
        deleteAllButton.addEventListener("click", async (event) => {
            event.preventDefault();
            try {
                const response = await fetch("/appointments", {
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    document.getElementById("appointmentsList").innerHTML = "<p class='text_message'>Все назначения удалены.</p>";
                } 
                else {
                    alert("Ошибка при удалении назначений.");
                }
            } 
            catch (error) {
                alert("Произошла ошибка. Попробуйте позже.");
            }
        });
    };
});