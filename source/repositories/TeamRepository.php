<?php

namespace repositories;

use PDO;
use Database;
use PDOException;

class TeamRepository
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function getTeamsByUserId($userId)
    {
        $stmt = $this->pdo->prepare("
            SELECT t.team_id, t.team_name
            FROM teams t
            JOIN user_teams ut ON t.team_id = ut.team_id
            WHERE ut.user_id = :uid
        ");
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function createTeamWithPlayers($teamName, $captainUserId, array $playerIds, array $positions)
    {
        try {
            $this->pdo->beginTransaction();
            $this->pdo->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");

            $playersIdsString = '{' . implode(',', $playerIds) . '}';

            $quotedPositions = array_map(function($p) {
                return "\"$p\"";
            }, $positions);

            $positionsString = '{' . implode(',', $quotedPositions) . '}';

            $stmt = $this->pdo->prepare("
                CALL create_team_with_players(:team_name, :created_by, :player_ids, :positions)
            ");
            $stmt->bindParam(':team_name', $teamName);
            $stmt->bindParam(':created_by', $captainUserId);
            $stmt->bindParam(':player_ids', $playersIdsString);
            $stmt->bindParam(':positions', $positionsString);

            $stmt->execute();
            $this->pdo->commit();

            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw new \Exception("Error creating team: " . $e->getMessage());
        }
    }

    public function countPlayersInTeam($teamId)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user_teams WHERE team_id = :team_id");
        $stmt->execute([':team_id' => $teamId]);
        return (int) $stmt->fetchColumn();
    }

    public function addUserToTeam($userId, $teamId, $position)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_teams (user_id, team_id, position)
            VALUES (:user_id, :team_id, :position)
        ");
        return $stmt->execute([
            ':user_id' => $userId,
            ':team_id' => $teamId,
            ':position' => $position
        ]);
    }

    public function isUserInTeam($userId, $teamId)
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM user_teams 
            WHERE team_id = :team_id AND user_id = :user_id
        ");
        $stmt->execute([
            ':team_id' => $teamId,
            ':user_id' => $userId
        ]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function removeUserFromTeam($userId, $teamId)
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM user_teams 
            WHERE user_id = :user_id AND team_id = :team_id
        ");
        return $stmt->execute([
            ':user_id' => $userId,
            ':team_id' => $teamId
        ]);
    }

    public function getAllTeams()
    {
        $stmt = $this->pdo->query("SELECT * FROM teams");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteTeamById($teamId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM teams WHERE team_id = :id");
        $stmt->execute([':id' => $teamId]);
    }


}
