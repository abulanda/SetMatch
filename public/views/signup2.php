<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['signup_data'] = $_POST;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/signup.css">
    <title>Sign up!</title>
</head>
<body>
<div class="header-bar">
    <div class="logo-section">
        <img src="public/img/logo2.svg" alt="SetMatch Logo" class="logo">
    </div>
</div>
<div class="container">
    <div class="content-section">
        <div class="welcome-text">
            <h1>Almost done!</h1>
            <p>It's worth adding this information about yourself:</p>
        </div>
        <form class="registration-form" method="POST" action="/register" enctype="multipart/form-data">            <label for="city">City:</label>
            <select id="city" name="city" required>
                <option value="" disabled selected>Select your city</option>
                <option value="Kraków">Kraków</option>
            </select>

            <label for="advancement">Advancement:</label>
            <select id="advancement" name="advancement" required>
                <option value="" disabled selected>Select your advancement level</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>

            <label for="position">Position:</label>
            <select id="position" name="position" required>
                <option value="" disabled selected>Select your preferred position</option>
                <option value="Setter">Setter</option>
                <option value="Outside hitter">Outside hitter</option>
                <option value="Opposite hitter">Opposite hitter</option>
                <option value="Middle blocker">Middle blocker</option>
                <option value="Libero">Libero</option>
            </select>

            <div class="file-upload-container">
                <p>Profile picture:</p>
                <label for="profile-picture" class="custom-file-upload">Choose File</label>
                <input type="file" id="profile-picture" name="profile-picture" accept="image/*" class="file-input">
                <span id="file-name">No file chosen</span>
            </div>

            <button type="submit">Continue</button>
        </form>
    </div>
</div>
<script src="public/js/signup2.js"></script>
</body>
</html>
