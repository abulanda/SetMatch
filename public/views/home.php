<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/home.css">
    <title>SetMatch</title>
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
                <div class="profile-picture">

                </div>
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
            <h2 class="main-header">They are looking for a player! <br>Take a look!</h2>
            <div class="teams-grid">
                <div class="team-card">
                    <img src="public/img/volleyball-court.jpg" alt="Volleyball Court" class="team-image">
                    <div class="team-info">
                        <div class="details">
                            <p class="team-name">Eagles</p>
                            <p class="team-details">12.12.2024 16:00<br>Kraków 1</p>
                        </div>
                        <div class="team-actions">
                            <p class="team-members">4/7</p>
                            <button class="join-button" onclick="location.href='calendar'">Join</button>
                        </div>
                    </div>
                </div>

                <div class="team-card">
                    <img src="public/img/volleyball-court.jpg" alt="Volleyball Court" class="team-image">
                    <div class="team-info">
                        <div class="details">
                            <p class="team-name">Dragons</p>
                            <p class="team-details">14.12.2024 20:00<br>Kraków 1</p>
                        </div>
                        <div class="team-actions">
                            <p class="team-members">6/7</p>
                            <button class="join-button" onclick="location.href='calendar'">Join</button>
                        </div>

                    </div>
                </div>
                <div class="team-card">
                    <img src="public/img/volleyball-court.jpg" alt="Volleyball Court" class="team-image">
                    <div class="team-info">
                        <div class="details">
                            <p class="team-name">Anna's Team</p>
                            <p class="team-details">12.12.2024 16:00<br>Kraków 1</p>
                        </div>
                        <div class="team-actions">
                            <p class="team-members">2/7</p>
                            <button class="join-button" onclick="location.href='calendar'">Join</button>
                        </div>

                    </div>
                </div>
                <div class="team-card">
                    <img src="public/img/volleyball-court.jpg" alt="Volleyball Court" class="team-image">
                    <div class="team-info">
                        <div class="details">
                            <p class="team-name">Grounders</p>
                            <p class="team-details">22.12.2024 19:00<br>Kraków 1</p>
                        </div>
                        <div class="team-actions">
                            <p class="team-members">5/7</p>
                            <button class="join-button" onclick="location.href='calendar'">Join</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>