<?php
namespace App\Models\Repositories;

use App\Core\Database;
use App\Interfaces\RepositoryInterface;
use PDO;

class IncidentRepository implements RepositoryInterface {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findById(int $id): ?object {
        $stmt = $this->db->prepare("SELECT i.*, u.name as citizen_name FROM incidents i JOIN users u ON i.user_id = u.id WHERE i.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    public function findAll(): array {
        return $this->db->query("SELECT i.*, u.name as citizen_name FROM incidents i JOIN users u ON i.user_id = u.id ORDER BY i.created_at DESC")->fetchAll(PDO::FETCH_OBJ);
    }

    public function findWithFilters(string $status = '', string $category = ''): array {
        $sql = "SELECT i.*, u.name as citizen_name FROM incidents i JOIN users u ON i.user_id = u.id WHERE 1=1";
        $params = [];

        if (!empty($status)) {
            $sql .= " AND i.status = ?";
            $params[] = $status;
        }
        if (!empty($category)) {
            $sql .= " AND i.category = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY i.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function create(string $title, string $desc, string $category, string $address, int $userId, string $priority, int $deadline): bool {
        $stmt = $this->db->prepare("INSERT INTO incidents (title, description, category, address, user_id, priority, resolution_deadline) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $desc, $category, $address, $userId, $priority, $deadline]);
    }

    public function deleteIncident(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM incidents WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateStatus(int $id, string $status, int $agentId, string $comment): bool {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("UPDATE incidents SET status = ?, agent_id = ? WHERE id = ?");
            $stmt->execute([$status, $agentId, $id]);

            $stmtHist = $this->db->prepare("INSERT INTO incident_history (incident_id, status_changed, agent_id, comment) VALUES (?, ?, ?, ?)");
            $stmtHist->execute([$id, $status, $agentId, $comment]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getHistory(int $incidentId): array {
        $stmt = $this->db->prepare("SELECT h.*, u.name as agent_name FROM incident_history h JOIN users u ON h.agent_id = u.id WHERE h.incident_id = ? ORDER BY h.changed_at DESC");
        $stmt->execute([$incidentId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getComments(int $incidentId): array {
        $stmt = $this->db->prepare("SELECT c.*, u.name as user_name, u.role FROM comments c JOIN users u ON c.user_id = u.id WHERE c.incident_id = ? ORDER BY c.created_at ASC");
        $stmt->execute([$incidentId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addComment(int $incidentId, int $userId, string $content): bool {
        $stmt = $this->db->prepare("INSERT INTO comments (incident_id, user_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$incidentId, $userId, $content]);
    }

    public function getStatsByStatus(): array {
        return $this->db->query("SELECT status, COUNT(*) as count FROM incidents GROUP BY status")->fetchAll(PDO::FETCH_OBJ);
    }

    public function getStatsByCategory(): array {
        return $this->db->query("SELECT category, COUNT(*) as count FROM incidents GROUP BY category")->fetchAll(PDO::FETCH_OBJ);
    }
}