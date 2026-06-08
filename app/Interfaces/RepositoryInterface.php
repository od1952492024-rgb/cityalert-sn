<?php
namespace App\Interfaces;

interface RepositoryInterface {
    public function findById(int $id): ?object;
    public function findAll(): array;
}