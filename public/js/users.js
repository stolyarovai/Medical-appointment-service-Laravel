document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".delete-user").forEach(button => {
        button.addEventListener("click", () => {
            const userId = button.dataset.id;

            if (confirm("Вы уверены, что хотите забанить этого пользователя?")) {
                fetch(`../actions/delete_user.php`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({id: userId}),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        button.closest(".user-item").remove();
                        alert("Пользователь забанен.");
                    } 
                    else {
                        alert("Ошибка: " + data.error);
                    }
                })
                .catch(error => console.error("Ошибка:", error));
            }
        });
    });
});