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
        <form class="registration-form">
            <label for="city">City:</label>
            <select id="city" name="city" required>
                <option value="" disabled selected>Select your city</option>
                <option value="krakow">Kraków</option>
            </select>

            <label for="advancement">Advancement:</label>
            <select id="advancement" name="advancement" required>
                <option value="" disabled selected>Select your advancement level</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>

            <label for="position">Position:</label>
            <select id="position" name="position">
                <option value="" disabled selected>Select your preferred position</option>
                <option value="setter">Setter</option>
                <option value="outside-hitter">Outside hitter</option>
                <option value="opposite-hitter">Opposite hitter</option>
                <option value="middle-blocker">Middle blocker</option>
                <option value="libero">Libero</option>
            </select>

            <div class="file-upload-container">
                <p>Profile picture:</p>
                <label for="profile-picture" class="custom-file-upload">Choose File</label>
                <input type="file" id="profile-picture" name="profile-picture" accept="image/*" class="file-input">
                <span id="file-name">No file chosen</span>
            </div>

            <a href="/home">
                <button type="button">Continue</button>
            </a>
        </form>
    </div>
</div>
</body>
</html>