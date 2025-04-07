<?php

namespace Domain\Repositories;

use Domain\Entities\User;

interface UserRepository {
    public function findAll(): array;
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function save(User $user): bool;
}
