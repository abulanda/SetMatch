<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="public/css/addteam.css">
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
                        <p> <?php echo isset($first_name) ? htmlspecialchars($first_name) : 'N/A'; ?></p>
                        <p> <?php echo isset($last_name) ? htmlspecialchars($last_name) : 'N/A'; ?></p>
                        <p> <?php echo isset($position) ? htmlspecialchars($position) : 'N/A'; ?></p>
                        <p> Advancement: <?php echo isset($skill_level) ? htmlspecialchars($skill_level) : 'N/A'; ?></p>
                        <p> <?php echo isset($city) ? htmlspecialchars($city) : 'N/A'; ?></p>
                        <p> id: <?php echo isset($user_id) ? htmlspecialchars($user_id) : 'N/A'; ?></p>
                    </div>
                </div>
                <div class="buttons-container">
                    <button type="button" class="create-team-btn" onclick="location.href='addteam1'">Create a team!</button>
                    <button type="button" class="home-page-btn" onclick="location.href='home'">HOME</button>
                </div>
            </div>
            <div class="main-page">
                <div class="team-form">
                    <form action="calendar" method="get">
                        <label for="team-name" class="form-label">Team name*</label>
                        <input type="text" id="team-name" name="team-name" class="form-input">
                    
                        <label for="position" class="form-label">Your position*</label>
                        <input type="text" id="position" name="position" class="form-input">
                    
                        <button type="submit" class="form-button">Continue</button>
                    </form>
                    
                </div>
            
                <div class="players-list">
                    <h2>Wanna play with friends? Add them now!</h2>
                    <p>does not work yet :(</p>
                    <div class="player-row">
                        <span>#2</span>
                        <input type="text" placeholder="id" class="player-input">
                        <input type="text" placeholder="position" class="player-input">
                    </div>
                    <div class="player-row">
                        <span>#3</span>
                        <input type="text" placeholder="id" class="player-input">
                        <input type="text" placeholder="position" class="player-input">
                    </div>
                    <div class="player-row">
                        <span>#4</span>
                        <input type="text" placeholder="id" class="player-input">
                        <input type="text" placeholder="position" class="player-input">
                    </div>
                    <div class="player-row">
                        <span>#5</span>
                        <input type="text" placeholder="id" class="player-input">
                        <input type="text" placeholder="position" class="player-input">
                    </div>
                    <div class="player-row">
                        <span>#6</span>
                        <input type="text" placeholder="id" class="player-input">
                        <input type="text" placeholder="position" class="player-input">
                    </div>
                    <div class="player-row">
                        <span>#7</span>
                        <input type="text" placeholder="id" class="player-input">
                        <input type="text" placeholder="position" class="player-input">
                    </div>
                </div>
                
            </div>
            
        </div>
    </body>
</html>