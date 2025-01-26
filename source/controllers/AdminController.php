<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/TeamRepository.php';
require_once __DIR__ . '/../repositories/MatchRepository.php';

use repositories\TeamRepository;
use repositories\MatchRepository;
use repositories\UserRepository;

class AdminController extends AppController
{
    private $userRepository;
    private $teamRepository;
    private $matchRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->teamRepository = new TeamRepository();
        $this->matchRepository = new MatchRepository();
    }

    public function admin()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
            header("Location: /login");
            exit();
        }

        $allUsers   = $this->userRepository->getAllUsers();
        $allTeams   = $this->teamRepository->getAllTeams();
        $allMatches = $this->matchRepository->getAllMatches();

        $userData = [
            'user_id'          => $_SESSION['user_id'],
            'nickname'         => $_SESSION['nickname'] ?? '',
            'city'             => $_SESSION['city'] ?? '',
            'skill_level'      => $_SESSION['skill_level'] ?? '',
            'position'         => $_SESSION['position'] ?? '',
            'first_name'       => $_SESSION['first_name'] ?? '',
            'last_name'        => $_SESSION['last_name'] ?? '',
            'profile_picture'  => $_SESSION['profile_picture'] ?? '',
            'usersList'        => $allUsers,
            'teamsList'        => $allTeams,
            'matchesList'      => $allMatches
        ];

        $this->render('admin', $userData);
    }

    public function deleteUser()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
            header("Location: /login");
            exit();
        }
        if (!isset($_GET['id'])) {
            header("Location: /admin");
            exit();
        }
        $userId = $_GET['id'];
        $this->userRepository->deleteUserById($userId);

        header("Location: /admin");
        exit();
    }

    public function deleteTeam()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
            header("Location: /login");
            exit();
        }
        if (!isset($_GET['id'])) {
            header("Location: /admin");
            exit();
        }
        $teamId = $_GET['id'];
        $this->teamRepository->deleteTeamById($teamId);

        header("Location: /admin");
        exit();
    }

    public function deleteMatch()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
            header("Location: /login");
            exit();
        }
        if (!isset($_GET['id'])) {
            header("Location: /admin");
            exit();
        }
        $matchId = $_GET['id'];
        $this->matchRepository->deleteMatchById($matchId);

        header("Location: /admin");
        exit();
    }
}
