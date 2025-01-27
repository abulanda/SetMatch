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
        <h1 class="page-title">Matches Summary</h1>
        <?php if (isset($messages) && !empty($messages)): ?>
            <div class="messages">
                <?php foreach($messages as $msg): ?>
                    <p>
                        <?= htmlspecialchars($msg) ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="matches-summary">
            <?php if (isset($userMatches)) {
                foreach ($userMatches as $m) {
                    $matchId       = $m['match_id'];
                    $teamId        = $m['team_id'];
                    $teamName      = htmlspecialchars($m['team_name']);
                    $matchDate     = htmlspecialchars($m['match_date']);
                    $matchTime     = htmlspecialchars($m['match_time']);
                    $location      = htmlspecialchars($m['location']);
                    $participants  = (int)$m['participants'];
                    ?>
                    <div class="match-card">
                        <h2 class="match-team"><?php echo $teamName; ?></h2>
                        <p class="match-info">Date: <?php echo $matchDate; ?></p>
                        <p class="match-info">Time: <?php echo $matchTime; ?></p>
                        <p class="match-info">Location: <?php echo $location; ?></p>
                        <p class="match-info">Participants: <?php echo $participants; ?>/7</p>
                        <button class="leave-button"
                                onclick="location.href='leaveMatch?match_id=<?php echo $matchId; ?>&team_id=<?php echo $teamId; ?>'">
                            Leave
                        </button>
                    </div>
                    <?php
                }
            } ?>
        </div>
    </div>
</div>
</body>
</html>
