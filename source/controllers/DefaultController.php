<?php

require_once 'AppController.php';
require_once __DIR__ . '/../Database.php';

require_once __DIR__ . '/../repositories/TeamRepository.php';
require_once __DIR__ . '/../repositories/MatchRepository.php';

use repositories\TeamRepository;
use repositories\MatchRepository;

class DefaultController extends AppController
{
    private $teamRepository;

    private $matchRepository;

    public function __construct()
    {
        parent::__construct();

        $this->teamRepository  = new TeamRepository();
        $this->matchRepository = new MatchRepository();
    }

    public function index()
    {
        $this->render('login');
    }

    public function login()
    {
        $this->render('login');
    }

    public function addMatch()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $teams = $this->teamRepository->getTeamsByUserId($_SESSION['user_id']);

        $userData = [
            'user_id'          => $_SESSION['user_id'],
            'nickname'         => $_SESSION['nickname'] ?? 'Guest',
            'city'             => $_SESSION['city'] ?? 'Unknown',
            'skill_level'      => $_SESSION['skill_level'] ?? 'N/A',
            'position'         => $_SESSION['position'] ?? 'N/A',
            'first_name'       => $_SESSION['first_name'] ?? '',
            'last_name'        => $_SESSION['last_name'] ?? '',
            'profile_picture'  => $_SESSION['profile_picture'] ?? '',
            'teams'            => $teams
        ];
        $this->render('addmatch', $userData);
    }

    public function addteam1()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        $userData = [
            'user_id'          => $_SESSION['user_id'],
            'nickname'         => $_SESSION['nickname'] ?? 'Guest',
            'city'             => $_SESSION['city'] ?? 'Unknown',
            'skill_level'      => $_SESSION['skill_level'] ?? 'N/A',
            'position'         => $_SESSION['position'] ?? 'N/A',
            'first_name'       => $_SESSION['first_name'] ?? '',
            'last_name'        => $_SESSION['last_name'] ?? '',
            'profile_picture'  => $_SESSION['profile_picture'] ?? '',
        ];
        $this->render('addteam1', $userData);
    }

    public function calendar()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userMatches = $this->matchRepository->getUserMatches($_SESSION['user_id']);

        $userData = [
            'user_id'          => $_SESSION['user_id'],
            'nickname'         => $_SESSION['nickname'] ?? 'Guest',
            'city'             => $_SESSION['city'] ?? 'Unknown',
            'skill_level'      => $_SESSION['skill_level'] ?? 'N/A',
            'position'         => $_SESSION['position'] ?? 'N/A',
            'first_name'       => $_SESSION['first_name'] ?? '',
            'last_name'        => $_SESSION['last_name'] ?? '',
            'profile_picture'  => $_SESSION['profile_picture'] ?? '',
            'userMatches'      => $userMatches
        ];

        $this->render('calendar', $userData);
    }

    public function home()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $allOpenMatches = $this->matchRepository->getOpenMatches();

        $userData = [
            'user_id'          => $_SESSION['user_id'],
            'nickname'         => $_SESSION['nickname'] ?? 'Guest',
            'city'             => $_SESSION['city'] ?? 'Unknown',
            'skill_level'      => $_SESSION['skill_level'] ?? 'N/A',
            'position'         => $_SESSION['position'] ?? 'N/A',
            'first_name'       => $_SESSION['first_name'] ?? '',
            'last_name'        => $_SESSION['last_name'] ?? '',
            'profile_picture'  => $_SESSION['profile_picture'] ?? '',
            'openMatches'      => $allOpenMatches
        ];
        $this->render('home', $userData);
    }

    public function signup1()
    {
        $this->render('signup1');
    }

    public function signup2()
    {
        $this->render('signup2');
    }

    public function temp()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        $userData = [
            'user_id'          => $_SESSION['user_id'],
            'nickname'         => $_SESSION['nickname'] ?? 'Guest',
            'city'             => $_SESSION['city'] ?? 'Unknown',
            'skill_level'      => $_SESSION['skill_level'] ?? 'N/A',
            'position'         => $_SESSION['position'] ?? 'N/A',
            'first_name'       => $_SESSION['first_name'] ?? '',
            'last_name'        => $_SESSION['last_name'] ?? '',
            'profile_picture'  => $_SESSION['profile_picture'] ?? '',
        ];
        $this->render('temp', $userData);
    }

    public function createTeamTransaction()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /home");
            exit;
        }
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $teamName       = isset($_POST['team-name']) ? $_POST['team-name'] : null;
        $captainUserId  = $_SESSION['user_id'];
        $captainPosition = isset($_POST['position']) ? $_POST['position'] : '';
        $playerIds      = array();
        $positions      = array();

        array_unshift($playerIds, $captainUserId);
        array_unshift($positions, $captainPosition);

        for ($i = 2; $i <= 7; $i++) {
            $pid = isset($_POST['player_id_'.$i]) ? $_POST['player_id_'.$i] : '';
            $pos = isset($_POST['player_position_'.$i]) ? $_POST['player_position_'.$i] : '';

            if (!empty($pid)) {
                if (empty($pos)) {
                    try {
                        $db = new \Database();
                        $pdo = $db->connect();
                        $stmt = $pdo->prepare("SELECT position FROM users WHERE user_id = :uid");
                        $stmt->execute([':uid' => $pid]);
                        $fetchedPos = $stmt->fetchColumn();
                        $pos = $fetchedPos ? $fetchedPos : 'Unknown';
                    } catch (\PDOException $e) {
                        $pos = 'Unknown';
                    }
                }
                $playerIds[] = (int)$pid;
                $positions[] = $pos;
            }
        }

        try {
            $this->teamRepository->createTeamWithPlayers(
                $teamName,
                $captainUserId,
                $playerIds,
                $positions
            );
            header("Location: /home");
            exit;
        } catch (\Exception $e) {
            echo "Error creating team: " . $e->getMessage();
        }
    }

    public function createMatchTransaction()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /home");
            exit;
        }
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $teamId    = isset($_POST['team']) ? $_POST['team'] : null;
        $matchDate = isset($_POST['date']) ? $_POST['date'] : '';
        $matchTime = isset($_POST['time']) ? $_POST['time'] : '';
        $location  = isset($_POST['where']) ? $_POST['where'] : '';
        $createdBy = $_SESSION['user_id'];

        try {
            $this->matchRepository->createMatch($teamId, $matchDate, $matchTime, $location, $createdBy);
            header("Location: /home");
            exit;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function joinMatch()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            header("Location: /home");
            exit();
        }
        $userId   = $_SESSION['user_id'];
        $teamId   = isset($_GET['team_id']) ? $_GET['team_id'] : null;
        $matchId  = isset($_GET['match_id']) ? $_GET['match_id'] : null;

        if (!$teamId || !$matchId) {
            header("Location: /home");
            exit();
        }

        try {
            $countPlayers = $this->teamRepository->countPlayersInTeam($teamId);
            if ($countPlayers >= 7) {
                echo "Team is already full!";
                return;
            }

            $position = $this->getUserPosition($userId);

            if ($this->teamRepository->isUserInTeam($userId, $teamId)) {
                echo "You are already in this team!";
                return;
            }

            $this->teamRepository->addUserToTeam($userId, $teamId, $position);

            header("Location: /calendar");
            exit();
        } catch (\Exception $e) {
            echo "Error joining team: " . $e->getMessage();
        }
    }

    public function leaveMatch()
    {
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
        $teamId  = isset($_GET['team_id']) ? $_GET['team_id'] : null;
        $matchId = isset($_GET['match_id']) ? $_GET['match_id'] : null;

        if (!$teamId || !$matchId) {
            header("Location: /home");
            exit();
        }

        try {
            if (!$this->teamRepository->isUserInTeam($userId, $teamId)) {
                echo "You are not in this team!";
                return;
            }

            $this->teamRepository->removeUserFromTeam($userId, $teamId);

            header("Location: /calendar");
            exit();
        } catch (\Exception $e) {
            echo "Error leaving match: " . $e->getMessage();
        }
    }

    private function getUserPosition($userId)
    {
        try {
            $db = new \Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare("SELECT position FROM users WHERE user_id = :uid");
            $stmt->execute([':uid' => $userId]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $row ? $row['position'] : 'Player';
        } catch (\PDOException $e) {
            return 'Player';
        }
    }

    public function searchMatchesAjax()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(["error" => "Unauthorized"]);
            exit();
        }

        $query = isset($_GET['query']) ? $_GET['query'] : '';

        $results = $this->matchRepository->searchOpenMatches($query);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($results);
    }


}
