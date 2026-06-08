<?php
namespace App\Models\Entities;

use App\Traits\Timestampable;

abstract class Incident {
    use Timestampable;

    protected string $title;
    protected string $description;
    protected string $address;

    public function __construct(string $title, string $description, string $address) {
        if (empty($title) || empty($description)) {
            throw new \App\Exceptions\ValidationException("Le titre et la description ne peuvent pas être vides.");
        }
        $this->title = $title;
        $this->description = $description;
        $this->address = $address;
    }

    abstract public function getPriority(): string;
    abstract public function getProcessingDeadline(): int;
}