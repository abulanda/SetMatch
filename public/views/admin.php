<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/admin.css">
    <title>Admin Panel</title>
</head>
<body>
<div class="header-bar">
    <div class="logo-section">
        <img src="public/img/logo2.svg" alt="SetMatch Logo" class="logo">
    </div>
    <div class="header-icons">
        <span class="logout-text" onclick="location.href='logout'">Log Out</span>
    </div>
</div>
<div class="container">
    <div class="side-panel">
        <div class="profile-section">

            <div class="profile-details">
                <p>ADMINISTRATION</p>
            </div>
        </div>
    </div>
    <div class="main-page">

        <h2>Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nickname</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php if (isset($usersList)): ?>
                <?php foreach($usersList as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['user_id']); ?></td>
                        <td><?= htmlspecialchars($u['nickname']); ?></td>
                        <td><?= htmlspecialchars($u['email']); ?></td>
                        <td><?= htmlspecialchars($u['role'] ?? 'USER'); ?></td>
                        <td><a href="deleteUser?id=<?= $u['user_id'] ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

        <h2>Teams</h2>
        <table>
            <tr><th>ID</th><th>Team Name</th><th>Created By</th><th>Action</th></tr>
            <?php if (isset($teamsList)): ?>
                <?php foreach($teamsList as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['team_id']); ?></td>
                        <td><?= htmlspecialchars($t['team_name']); ?></td>
                        <td><?= htmlspecialchars($t['created_by']); ?></td>
                        <td><a href="deleteTeam?id=<?= $t['team_id'] ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

        <h2>Matches</h2>
        <table>
            <tr><th>ID</th><th>Date</th><th>Time</th><th>Location</th><th>Created By</th><th>Action</th></tr>
            <?php if (isset($matchesList)): ?>
                <?php foreach($matchesList as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['match_id']); ?></td>
                        <td><?= htmlspecialchars($m['match_date']); ?></td>
                        <td><?= htmlspecialchars($m['match_time']); ?></td>
                        <td><?= htmlspecialchars($m['location']); ?></td>
                        <td><?= htmlspecialchars($m['created_by']); ?></td>
                        <td><a href="deleteMatch?id=<?= $m['match_id'] ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

    </div>
</div>
</body>
</html>
