<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/addmatch.css">
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
        <span class="logout-text" onclick="location.href='logout'">Log Out</span>
    </div>
</div>
<div class="container">
    <div class="side-panel">
        <div class="profile-section">
            <div class="profile-picture"
                 style="
                 <?php if (isset($profile_picture) && !empty($profile_picture)): ?>
                         background-image: url('../<?php echo htmlspecialchars($profile_picture); ?>');
                 <?php else: ?>
                         background-color: #D79685;
                 <?php endif; ?>
                         ">
            </div>
            <div class="profile-details">
                <p><?php echo isset($first_name) ? htmlspecialchars($first_name) : 'N/A'; ?></p>
                <p><?php echo isset($last_name) ? htmlspecialchars($last_name) : 'N/A'; ?></p>
                <p><?php echo isset($position) ? htmlspecialchars($position) : 'N/A'; ?></p>
                <p>Advancement: <?php echo isset($skill_level) ? htmlspecialchars($skill_level) : 'N/A'; ?></p>
                <p><?php echo isset($city) ? htmlspecialchars($city) : 'N/A'; ?></p>
                <p>id: <?php echo isset($user_id) ? htmlspecialchars($user_id) : 'N/A'; ?></p>
            </div>
        </div>
        <div class="buttons-container">
            <button type="button" class="create-team-btn" onclick="location.href='addteam1'">Create a team!</button>
            <button type="button" class="home-page-btn" onclick="location.href='home'">HOME</button>
        </div>
    </div>
    <div class="main-page">
        <div class="form-container">
            <h1 class="form-title">Let’s make it real!</h1>
            <form class="game-form" action="createMatchTransaction" method="POST">
                <label class="form-label" for="team">Which team?</label>
                <select id="team" name="team" class="form-input">
                    <option value="" disabled selected>Select team</option>
                    <?php if (isset($teams)) {
                        foreach ($teams as $t) {
                            echo '<option value="'.$t['team_id'].'">'.htmlspecialchars($t['team_name']).'</option>';
                        }
                    } ?>
                </select>
                <label class="form-label" for="date">When?</label>
                <div class="form-row">
                    <input type="date" id="date" name="date" class="form-input">
                    <input type="time" id="time" name="time" class="form-input">
                </div>
                <label class="form-label" for="where">Where?</label>
                <select id="where" name="where" class="form-input">
                    <option value="" disabled selected>Select hall</option>
                    <option value="Kraków Hall 1">Kraków Hall 1</option>
                    <option value="Kraków Hall 2">Kraków Hall 2</option>
                    <option value="Kraków Hall 3">Kraków Hall 3</option>
                    <option value="Kraków Hall 4">Kraków Hall 4</option>
                </select>
                <button type="submit" class="action-button primary">LET’S PLAY</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
