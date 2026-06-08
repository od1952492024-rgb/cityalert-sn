<?php
namespace App\Models\Entities;

class VoirieIncident extends Incident {
    public function getPriority(): string { return "Haute"; }
    public function getProcessingDeadline(): int { return 3; }
}