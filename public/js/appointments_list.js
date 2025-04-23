document.addEventListener("DOMContentLoaded", () => {
    const deleteAllButton = document.getElementById("deleteAllButton");

    if (deleteAllButton) {
        deleteAllButton.addEventListener("click", async () => {
            if (confirm("Вы уверены, что хотите удалить все назначения?")) {
                try {
                    const response = await fetch("../actions/delete_all_appointments.php", {
                        method: "POST",
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
            }
        });
    };
});