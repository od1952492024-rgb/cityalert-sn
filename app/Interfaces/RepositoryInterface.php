<?php
/* Ajusté par Ndeye Coumba */
namespace App\Interfaces;

interface RepositoryInterface {
    public function findById(int $id): ?object;
    public function findAll(): array;
}