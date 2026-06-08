<?php
namespace App\Models\Entities;

class DechetIncident extends Incident {
    public function getPriority(): string { return "Normale"; }
    public function getProcessingDeadline(): int { return 7; }
}