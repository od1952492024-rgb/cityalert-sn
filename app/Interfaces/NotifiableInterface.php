<?php
/* Ajusté par Ndeye Coumba */
namespace App\Interfaces;

interface NotifiableInterface {
    public function logSystemAction(string $message): void;
}