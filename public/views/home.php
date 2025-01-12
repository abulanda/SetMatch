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
        <h2 class="main-header">They are looking for a player!<br>Take a look!</h2>
        <div class="teams-grid">
            <?php
            $hallImages = [
                'Kraków Hall 1' => 'volleyball-court1.jpg',
                'Kraków Hall 2' => 'volleyball-court2.jpg',
                'Kraków Hall 3' => 'volleyball-court3.jpg',
                'Kraków Hall 4' => 'volleyball-court4.jpg'
            ];
            if (isset($openMatches)) {
                foreach ($openMatches as $match) {
                    $teamId       = $match['team_id'];
                    $teamName     = htmlspecialchars($match['team_name']);
                    $matchId      = $match['match_id'];
                    $matchDate    = htmlspecialchars($match['match_date']);
                    $matchTime    = htmlspecialchars($match['match_time']);
                    $location     = htmlspecialchars($match['location']);
                    $participants = (int)$match['participants'];
                    $imgFile      = 'volleyball-court.jpg';
                    if (isset($hallImages[$location])) {
                        $imgFile = $hallImages[$location];
                    }
                    echo '
            <div class="team-card">
                <img src="public/img/'.$imgFile.'" alt="Volleyball Court" class="team-image">
                <div class="team-info">
                    <div class="details">
                        <p class="team-name">'.$teamName.'</p>
                        <p class="team-details">'.$matchDate.' '.$matchTime.'<br>'.$location.'</p>
                    </div>
                    <div class="team-actions">
                        <p class="team-members">'.$participants.'/7</p>
                        <button class="join-button"
                            onclick="location.href=\'joinMatch?match_id='.$matchId.'&team_id='.$teamId.'\'">
                            Join
                        </button>
                    </div>
                </div>
            </div>
            ';
                }
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
