<?php
namespace App\Controllers;

use App\Models\Repositories\IncidentRepository;
use App\Models\Entities\VoirieIncident;
use App\Models\Entities\DechetIncident;
use App\Models\Entities\EclairageIncident;
use App\Models\Entities\EauIncident;
use App\Exceptions\EntityNotFoundException;

class IncidentController {
    private IncidentRepository $incidentRepo;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /cityalert/public/');
            exit;
        }
        $this->incidentRepo = new IncidentRepository();
    }

    public function index() {
        $status = $_GET['status'] ?? '';
        $category = $_GET['category'] ?? '';
        
        $incidents = $this->incidentRepo->findWithFilters($status, $category);
        $view = __DIR__ . '/../../views/incidents/index.php';
        require __DIR__ . '/../../views/layout.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = htmlspecialchars($_POST['title']);
            $desc = htmlspecialchars($_POST['description']);
            $category = htmlspecialchars($_POST['category']);
            $address = htmlspecialchars($_POST['address']);
            
            switch($category) {
                case 'voirie': $entity = new VoirieIncident($title, $desc, $address); break;
                case 'eclairage': $entity = new EclairageIncident($title, $desc, $address); break;
                case 'dechets': $entity = new DechetIncident($title, $desc, $address); break;
                case 'eau': $entity = new EauIncident($title, $desc, $address); break;
                default: throw new \App\Exceptions\ValidationException("Catégorie invalide.");
            }

            $this->incidentRepo->create(
                $title, $desc, $category, $address, 
                $_SESSION['user_id'], $entity->getPriority(), $entity->getProcessingDeadline()
            );

            header('Location: /cityalert/public/incidents');
            exit;
        }
        $view = __DIR__ . '/../../views/incidents/create.php';
        require __DIR__ . '/../../views/layout.php';
    }

    public function show(int $id) {
        $incident = $this->incidentRepo->findById($id);
        if (!$incident) {
            throw new EntityNotFoundException("Le signalement #{$id} n'existe pas en base de données.");
        }

        $comments = $this->incidentRepo->getComments($id);
        $history = $this->incidentRepo->getHistory($id);

        $view = __DIR__ . '/../../views/incidents/show.php';
        require __DIR__ . '/../../views/layout.php';
    }

    public function updateStatus(int $id) {
        if ($_SESSION['user_role'] !== 'agent' && $_SESSION['user_role'] !== 'admin') {
            die("Droits insuffisants.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = htmlspecialchars($_POST['status']);
            $comment = htmlspecialchars($_POST['comment']);
            $this->incidentRepo->updateStatus($id, $status, $_SESSION['user_id'], $comment);
        }
        header('Location: /cityalert/public/incidents/show/' . $id);
        exit;
    }

    public function addComment(int $id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = htmlspecialchars($_POST['content']);
            $this->incidentRepo->addComment($id, $_SESSION['user_id'], $content);
        }
        header('Location: /cityalert/public/incidents/show/' . $id);
        exit;
    }

    public function delete(int $id) {
        $incident = $this->incidentRepo->findById($id);
        if ($incident && $incident->status === 'Nouveau' && $incident->user_id == $_SESSION['user_id']) {
            $this->incidentRepo->deleteIncident($id);
        }
        header('Location: /cityalert/public/incidents');
        exit;
    }
}