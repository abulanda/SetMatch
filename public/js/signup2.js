document.addEventListener("DOMContentLoaded", function() {
    const inputFile = document.getElementById('profile-picture');
    const fileNameSpan = document.getElementById('file-name');

    inputFile.addEventListener('change', function() {
        const file = inputFile.files[0];
        if (file) {
            fileNameSpan.textContent = file.name;
        } else {
            fileNameSpan.textContent = "No file chosen";
        }
    });
});