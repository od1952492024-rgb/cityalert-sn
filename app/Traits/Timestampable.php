<?php
namespace App\Traits;

trait Timestampable {
    private string $createdAt;

    public function getCreatedAt(): string { return $this->createdAt; }
    public function setCreatedAt(string $date): void { $this->createdAt = $date; }
}