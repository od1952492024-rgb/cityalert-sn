<?php
namespace App\Controllers;

use App\Models\Repositories\IncidentRepository;

class AdminController {
    private IncidentRepository $incidentRepo;

    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /cityalert/public/');
            exit;
        }
        $this->incidentRepo = new IncidentRepository();
    }

    public function dashboard() {
        $statsStatus = $this->incidentRepo->getStatsByStatus();
        $statsCategory = $this->incidentRepo->getStatsByCategory();

        $view = __DIR__ . '/../../views/admin/dashboard.php';
        require __DIR__ . '/../../views/layout.php';
    }
}