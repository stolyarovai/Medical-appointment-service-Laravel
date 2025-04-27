document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    document.querySelectorAll(".delete-user").forEach(button => {
        button.addEventListener("click", () => {
            const userId = button.dataset.id;

            if (confirm("Вы уверены, что хотите забанить этого пользователя?")) {
                fetch(`/users/${userId}`, {
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
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