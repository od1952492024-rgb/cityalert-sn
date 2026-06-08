<?php
namespace App\Interfaces;

interface NotifiableInterface {
    public function logSystemAction(string $message): void;
}