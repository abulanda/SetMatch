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
        <form action="createTeamTransaction" method="POST" class="form">
            <div class="team-form">
            <label for="team-name" class="form-label">Team name*</label>
            <input type="text" id="team-name" name="team-name" class="form-input">

            <label for="position" class="form-label">Your position*</label>
            <select id="position" name="position" class="form-input">
                <option value="Libero"          <?php echo ($position === 'Libero')          ? 'selected' : ''; ?>>Libero</option>
                <option value="Setter"          <?php echo ($position === 'Setter')          ? 'selected' : ''; ?>>Setter</option>
                <option value="Outside hitter"  <?php echo ($position === 'Outside hitter')  ? 'selected' : ''; ?>>Outside hitter</option>
                <option value="Opposite hitter" <?php echo ($position === 'Opposite hitter') ? 'selected' : ''; ?>>Opposite hitter</option>
                <option value="Middle blocker"  <?php echo ($position === 'Middle blocker')  ? 'selected' : ''; ?>>Middle blocker</option>
            </select>



            <button type="submit" class="form-button">Continue</button>
            </div>

            <?php if (isset($messages) && !empty($messages)): ?>
                <div class="error-messages">
                    <?php foreach ($messages as $msg): ?>
                        <p><?php echo htmlspecialchars($msg); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="players-list">
                <h2>Wanna play with friends? Add them now!</h2>
                <p>Just fill their ID and optionally position</p>

                <?php for($i = 2; $i <= 7; $i++): ?>
                    <div class="player-row">
                        <span>#<?php echo $i; ?></span>
                        <input type="text" placeholder="id" class="player-input" name="player_id_<?php echo $i; ?>">
                        <select name="player_position_<?php echo $i; ?>" class="player-input">
                            <option value="">Copy from the user profile</option>
                            <option value="Libero">Libero</option>
                            <option value="Setter">Setter</option>
                            <option value="Outside hitter">Outside hitter</option>
                            <option value="Opposite hitter">Opposite hitter</option>
                            <option value="Middle blocker">Middle blocker</option>
                        </select>
                    </div>
                <?php endfor; ?>
            </div>
        </form>
    </div>
</div>
<script src="public/js/addteam.js"></script>
</body>
</html>
