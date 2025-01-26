document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const resultsContainer = document.getElementById("searchResults");

    function displayMatches(matches) {
        resultsContainer.innerHTML = "";

        if (!matches || matches.length === 0) {
            resultsContainer.innerHTML = "<p>No matches found.</p>";
            return;
        }

        matches.forEach(match => {
            const div = document.createElement("div");
            div.className = "search-match";
            div.innerHTML = `
        <p><strong>Team:</strong> ${match.team_name}</p>
        <p><strong>Date:</strong> ${match.match_date}</p>
        <p><strong>Time:</strong> ${match.match_time}</p>
        <p><strong>Location:</strong> ${match.location}</p>
        <p><strong>Participants:</strong> ${match.participants}</p>
      `;
            resultsContainer.appendChild(div);
        });
    }

    function searchMatchesAjax(query) {
        fetch(`/searchMatchesAjax?query=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                displayMatches(data);
            })
            .catch(err => {
                console.error("Error during fetch:", err);
                resultsContainer.innerHTML = "<p>Error occurred while searching.</p>";
            });
    }

    searchInput.addEventListener("input", () => {
        const query = searchInput.value.trim();
        if (query.length > 0) {
            searchMatchesAjax(query);
        } else {
            resultsContainer.innerHTML = "";
        }
    });

    


});


