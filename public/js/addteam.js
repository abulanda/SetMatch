document.addEventListener("DOMContentLoaded", function() {
    const playerRows = document.querySelectorAll(".player-row");

    playerRows.forEach(row => {
        const inputId = row.querySelector("input.player-input[name^='player_id_']");

        inputId.addEventListener("blur", function() {
            const userId = inputId.value.trim();
            if(userId !== "") {
                fetch(`/checkUserExistsAjax?user_id=${encodeURIComponent(userId)}`)
                    .then(resp => {
                        if(!resp.ok) {
                            throw new Error("HTTP error " + resp.status);
                        }
                        return resp.json();
                    })
                    .then(data => {
                        if(!data.exists) {
                            alert(`User with ID=${userId} does not exist!`);
                            inputId.value = "";
                        }
                    })
                    .catch(err => {
                        console.error(err);
                    });
            }
        });
    });
});
