document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".registration-form");
    if (!form) return;

    const passwordInput = form.querySelector("input[name='password']");

    const messagesContainer = document.createElement("div");
    messagesContainer.classList.add("signup-messages");

    form.insertBefore(messagesContainer, form.firstChild);

    form.addEventListener("submit", function(e) {
        messagesContainer.innerHTML = "";
        const errors = [];

        if (passwordInput.value.trim().length < 5) {
            errors.push("Password should be at least 5 characters long");
        }


        if (errors.length > 0) {
            e.preventDefault();

            errors.forEach(err => {
                const p = document.createElement("p");
                p.textContent = err;
                messagesContainer.appendChild(p);
            });
        }
    });
});
