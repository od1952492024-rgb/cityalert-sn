<?php
namespace App\Models\Entities;

class EauIncident extends Incident {
    public function getPriority(): string { return "Urgente"; }
    public function getProcessingDeadline(): int { return 1; }
}