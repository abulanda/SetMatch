<?php

namespace repositories;

use PDO;
use Database;
use PDOException;

class MatchRepository
{

    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function getUserMatches($userId)
    {
        $stmt = $this->pdo->prepare("
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
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getOpenMatches()
    {

        $stmt = $this->pdo->query("
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
        AND (
            m.match_date > CURRENT_DATE
            OR (
                m.match_date = CURRENT_DATE
                AND m.match_time > CURRENT_TIME
            )
        )
        ORDER BY m.match_date, m.match_time
    ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }


    public function createMatch($teamId, $matchDate, $matchTime, $location, $createdBy)
    {
        try {
            $this->pdo->beginTransaction();
            $this->pdo->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");

            $stmt = $this->pdo->prepare("
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

            $stmtTeams = $this->pdo->prepare("
                INSERT INTO match_teams (match_id, team_id)
                VALUES (:match_id, :team_id)
            ");
            $stmtTeams->execute([
                ':match_id' => $matchId,
                ':team_id'  => $teamId
            ]);

            $this->pdo->commit();
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw new \Exception("Error creating match: " . $e->getMessage());
        }
    }

    public function searchOpenMatches($query)
    {
        $stmt = $this->pdo->prepare("
        SELECT m.match_id,
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
        WHERE
            (
                SELECT COUNT(*)
                FROM user_teams
                WHERE user_teams.team_id = t.team_id
            ) < 7
            AND (
                t.team_name ILIKE :search
                OR m.location ILIKE :search
            )
        ORDER BY m.match_date, m.match_time
    ");

        $searchParam = '%' . $query . '%';
        $stmt->execute([':search' => $searchParam]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results ?: [];
    }


    public function getAllMatches()
    {
        $stmt = $this->pdo->query("SELECT * FROM matches");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteMatchById($matchId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM matches WHERE match_id = :id");
        $stmt->execute([':id' => $matchId]);
    }


}
