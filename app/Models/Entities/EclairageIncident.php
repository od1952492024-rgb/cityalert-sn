<?php
namespace App\Models\Entities;

class EclairageIncident extends Incident {
    public function getPriority(): string { return "Moyenne"; }
    public function getProcessingDeadline(): int { return 5; }
}