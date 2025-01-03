<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="public/css/calendar.css">
        <title>SetMatch - Matches Summary</title>
    </head>
    <body>
        <div class="header-bar">
            <div class="logo-section">
                <img src="public/img/logo2.svg" alt="SetMatch Logo" class="logo">
            </div>
            <div class="header-icons">
                <button class="icon-button" onclick="location.href='calendar'">
                    <img src="public/img/calendar.svg" alt="calendar img" class="pictures">
                </button>
                <button class="icon-button" onclick="location.href='addmatch'">
                    <img src="public/img/add.svg" alt="plus img" class="pictures">
                </button>
                <button class="icon-button" onclick="location.href='temp'">
                    <img src="public/img/chat.svg" alt="chat img" class="pictures">
                </button>
                <button class="icon-button" onclick="location.href='temp'">
                    <img src="public/img/magnifier.svg" alt="magnifier img" class="pictures">
                </button>
                <span class="logout-text" onclick="location.href='login'">Log Out</span>
            </div>
        </div>
        <div class="container">
            <div class="side-panel">
                <div class="profile-section">
                    <div class="profile-picture"></div>
                    <div class="profile-details">
                        <p>Josh</p>
                        <p>Swift</p>
                        <p>libero</p>
                        <p>B</p>
                        <p>Kraków</p>
                        <p>#0001</p>
                    </div>
                </div>
                <div class="buttons-container">
                    <button type="button" class="create-team-btn" onclick="location.href='addteam1'">Create a team!</button>
                    <button type="button" class="home-page-btn" onclick="location.href='home'">HOME</button>
                </div>
            </div>
            <div class="main-page">
                <h1 class="page-title">Matches Summary</h1>
                <div class="matches-summary">
                    <div class="match-card">
                        <h2 class="match-team">Eagles</h2>
                        <p class="match-info">Date: 12.12.2024</p>
                        <p class="match-info">Time: 16:00</p>
                        <p class="match-info">Location: Kraków Hall 1</p>
                        <p class="match-info">Participants: 6/7</p>
                    </div>
                    <div class="match-card">
                        <h2 class="match-team">Dragons</h2>
                        <p class="match-info">Date: 14.12.2024</p>
                        <p class="match-info">Time: 20:00</p>
                        <p class="match-info">Location: Kraków Hall 2</p>
                        <p class="match-info">Participants: 5/7</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
