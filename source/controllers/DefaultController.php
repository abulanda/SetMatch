<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        $this->render('login');
    }

    public function login() {
        $this->render('login');
    }

    public function addMatch() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        $db = new Database();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("
            SELECT t.team_id, t.team_name
            FROM teams t
            JOIN user_teams ut ON t.team_id = ut.team_id
            WHERE ut.user_id = :uid
        ");
        $stmt->execute([':uid' => $_SESSION['user_id']]);
        $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userData = [
            'user_id' => $_SESSION['user_id'],
            'nickname' => $_SESSION['nickname'] ?? 'Guest',
            'city' => $_SESSION['city'] ?? 'Unknown',
            'skill_level' => $_SESSION['skill_level'] ?? 'N/A',
            'position' => $_SESSION['position'] ?? 'N/A',
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name' => $_SESSION['last_name'] ?? '',
            'profile_picture' => $_SESSION['profile_picture'] ?? '',
            'teams' => $teams
        ];
        $this->render('addmatch', $userData);
    }

    public function addteam1() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        $userData = [
            'user_id' => $_SESSION['user_id'],
            'nickname' => $_SESSION['nickname'] ?? 'Guest',
            'city' => $_SESSION['city'] ?? 'Unknown',
            'skill_level' => $_SESSION['skill_level'] ?? 'N/A',
            'position' => $_SESSION['position'] ?? 'N/A',
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name' => $_SESSION['last_name'] ?? '',
            'profile_picture' => $_SESSION['profile_picture'] ?? '',
        ];
        $this->render('addteam1', $userData);
    }

    public function calendar() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $db = new Database();
        $pdo = $db->connect();

        $stmt = $pdo->prepare("
        SELECT m.match_id,
               t.team_id,
               t.team_name,
               m.match_date,
               m.match_time,
               m.location,
               (
                   SELECT COUNT(*) 
                   FROM user_teams 
                   WHERE user_teams.team_id = t.team_id
               ) AS participants
        FROM matches m
        JOIN match_teams mt ON m.match_id = mt.match_id
        JOIN teams t       ON t.team_id = mt.team_id
        JOIN user_teams ut ON ut.team_id = t.team_id
        WHERE ut.user_id = :uid
        ORDER BY m.match_date, m.match_time
    ");
        $stmt->execute([':uid' => $_SESSION['user_id']]);
        $userMatches = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userData = [
            'user_id'      => $_SESSION['user_id'],
            'nickname'     => $_SESSION['nickname'] ?? 'Guest',
            'city'         => $_SESSION['city'] ?? 'Unknown',
            'skill_level'  => $_SESSION['skill_level'] ?? 'N/A',
            'position'     => $_SESSION['position'] ?? 'N/A',
            'first_name'   => $_SESSION['first_name'] ?? '',
            'last_name'    => $_SESSION['last_name'] ?? '',
            'profile_picture' => $_SESSION['profile_picture'] ?? '',
            'userMatches'  => $userMatches
        ];

        $this->render('calendar', $userData);
    }


    public function home() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

         //var_dump($_SESSION['profile_picture']);
         //die();

        $db = new Database();
        $pdo = $db->connect();
        $stmt = $pdo->query("
            SELECT m.match_id,
                   t.team_id,
                   t.team_name,
                   m.match_date,
                   m.match_time,
                   m.location,
                   (
                       SELECT COUNT(*) 
                       FROM user_teams 
                       WHERE user_teams.team_id = t.team_id
                   ) AS participants
            FROM matches m
            JOIN match_teams mt ON m.match_id = mt.match_id
            JOIN teams t ON t.team_id = mt.team_id
            WHERE (
                SELECT COUNT(*) 
                FROM user_teams 
                WHERE user_teams.team_id = t.team_id
            ) < 7
            ORDER BY m.match_date, m.match_time
        ");

        $allOpenMatches = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userData = [
            'user_id' => $_SESSION['user_id'],
            'nickname' => $_SESSION['nickname'] ?? 'Guest',
            'city' => $_SESSION['city'] ?? 'Unknown',
            'skill_level' => $_SESSION['skill_level'] ?? 'N/A',
            'position' => $_SESSION['position'] ?? 'N/A',
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name' => $_SESSION['last_name'] ?? '',
            'profile_picture' => $_SESSION['profile_picture'] ?? '',
            'openMatches' => $allOpenMatches
        ];
        $this->render('home', $userData);
    }

    public function signup1() {
        $this->render('signup1');
    }

    public function signup2() {
        $this->render('signup2');
    }

    public function temp() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        $userData = [
            'user_id' => $_SESSION['user_id'],
            'nickname' => $_SESSION['nickname'] ?? 'Guest',
            'city' => $_SESSION['city'] ?? 'Unknown',
            'skill_level' => $_SESSION['skill_level'] ?? 'N/A',
            'position' => $_SESSION['position'] ?? 'N/A',
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name' => $_SESSION['last_name'] ?? '',
            'profile_picture' => $_SESSION['profile_picture'] ?? '',
        ];
        $this->render('temp', $userData);
    }

    public function createTeamTransaction() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /home");
            exit;
        }
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $teamName = $_POST['team-name'] ?? null;
        $captainUserId = $_SESSION['user_id'];
        $captainPosition = $_POST['position'] ?? '';
        $playerIds = [];
        $positions = [];

        array_unshift($playerIds, $captainUserId);
        array_unshift($positions, $captainPosition);

        for ($i = 2; $i <= 7; $i++) {
            $pid = $_POST['player_id_'.$i] ?? '';
            $pos = $_POST['player_position_'.$i] ?? '';

            if (!empty($pid)) {
                if (empty($pos)) {
                    try {
                        $db = new Database();
                        $pdo = $db->connect();
                        $stmt = $pdo->prepare("SELECT position FROM users WHERE user_id = :uid");
                        $stmt->execute([':uid' => $pid]);
                        $fetchedPos = $stmt->fetchColumn();
                        if ($fetchedPos) {
                            $pos = $fetchedPos;
                        } else {
                            $pos = 'Unknown';
                        }
                    } catch (PDOException $e) {
                        $pos = 'Unknown';
                    }
                }
                $playerIds[] = (int)$pid;
                $positions[] = $pos;
            }
        }

        $playersIdsString = '{' . implode(',', $playerIds) . '}';

        $quotedPositions = array_map(function($p) {
            return '"' . $p . '"';
        }, $positions);
        $positionsString = '{' . implode(',', $quotedPositions) . '}';

        try {
            $db = new Database();
            $pdo = $db->connect();
            $pdo->beginTransaction();
            $pdo->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");

            $stmt = $pdo->prepare("CALL create_team_with_players(:team_name, :created_by, :player_ids, :positions)");
            $stmt->bindParam(':team_name', $teamName, PDO::PARAM_STR);
            $stmt->bindParam(':created_by', $captainUserId, PDO::PARAM_INT);
            $stmt->bindParam(':player_ids', $playersIdsString, PDO::PARAM_STR);
            $stmt->bindParam(':positions', $positionsString, PDO::PARAM_STR);
            $stmt->execute();

            $pdo->commit();
            header("Location: /home");
            exit;
        } catch (PDOException $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            echo "Error creating team: " . $e->getMessage();
        }
    }


    public function createMatchTransaction() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /home");
            exit;
        }
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        $teamId = $_POST['team'] ?? null;
        $matchDate = $_POST['date'] ?? '';
        $matchTime = $_POST['time'] ?? '';
        $location = $_POST['where'] ?? '';
        $createdBy = $_SESSION['user_id'];
        try {
            $db = new Database();
            $pdo = $db->connect();

            $pdo->beginTransaction();
            $pdo->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");

            $stmt = $pdo->prepare("
            INSERT INTO matches (match_date, match_time, location, created_by)
            VALUES (:match_date, :match_time, :location, :created_by)
            RETURNING match_id
        ");
            $stmt->execute([
                ':match_date' => $matchDate,
                ':match_time' => $matchTime,
                ':location'   => $location,
                ':created_by' => $createdBy
            ]);
            $matchId = $stmt->fetchColumn();

            $stmtTeams = $pdo->prepare("
            INSERT INTO match_teams (match_id, team_id)
            VALUES (:match_id, :team_id)
        ");
            $stmtTeams->execute([
                ':match_id' => $matchId,
                ':team_id'  => $teamId
            ]);

            $pdo->commit();
            header("Location: /home");
            exit;
        } catch (PDOException $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            echo "Error creating match: " . $e->getMessage();
        }
    }


    public function joinMatch() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            header("Location: /home");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $teamId = $_GET['team_id'] ?? null;
        $matchId = $_GET['match_id'] ?? null;
        if (!$teamId || !$matchId) {
            header("Location: /home");
            exit();
        }
        try {
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_teams WHERE team_id = :team_id");
            $stmt->execute([':team_id' => $teamId]);
            $countPlayers = $stmt->fetchColumn();
            if ($countPlayers >= 7) {
                echo "Team is already full!";
                return;
            }
            $stmt = $pdo->prepare("SELECT position FROM users WHERE user_id = :uid");
            $stmt->execute([':uid' => $userId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $userPosition = $row ? $row['position'] : 'Player';
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_teams WHERE team_id = :team_id AND user_id = :user_id");
            $stmt->execute([':team_id' => $teamId, ':user_id' => $userId]);
            $alreadyIn = $stmt->fetchColumn();
            if ($alreadyIn > 0) {
                echo "You are already in this team!";
                return;
            }
            $stmt = $pdo->prepare("
                INSERT INTO user_teams (user_id, team_id, position)
                VALUES (:user_id, :team_id, :position)
            ");
            $stmt->execute([
                ':user_id' => $userId,
                ':team_id' => $teamId,
                ':position' => $userPosition
            ]);
            header("Location: /calendar");
            exit();
        } catch (PDOException $e) {
            echo "Error joining team: " . $e->getMessage();
        }
    }

    public function leaveMatch() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            header("Location: /home");
            exit();
        }
        $userId  = $_SESSION['user_id'];
        $teamId  = $_GET['team_id'] ?? null;
        $matchId = $_GET['match_id'] ?? null;
        if (!$teamId || !$matchId) {
            header("Location: /home");
            exit();
        }
        try {
            $db = new Database();
            $pdo = $db->connect();

            $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM user_teams 
            WHERE user_id = :user_id AND team_id = :team_id
        ");
            $stmt->execute([
                ':user_id' => $userId,
                ':team_id' => $teamId
            ]);
            $count = $stmt->fetchColumn();
            if ($count == 0) {
                echo "You are not in this team!";
                return;
            }

            $stmt = $pdo->prepare("
            DELETE FROM user_teams 
            WHERE user_id = :user_id AND team_id = :team_id
        ");
            $stmt->execute([
                ':user_id' => $userId,
                ':team_id' => $teamId
            ]);

            header("Location: /calendar");
            exit();
        } catch (PDOException $e) {
            echo "Error leaving match: " . $e->getMessage();
        }
    }

}
