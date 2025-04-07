<?php

namespace Infrastructure\Persistence;

use Domain\Entities\User;
use Domain\Repositories\UserRepository;
use mysqli;

class UserRepositoryImpl implements UserRepository {
    public function __construct(private mysqli $db) {}

    public function findAll():array{
        $result = $this->db->query("SELECT id, name, cpf_cnpj, email, password, type FROM users");
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[$row['id']] = new User(...$row);
        }
        return $rows;
    }
    public function findById(int $id): ?User {
        $stmt = $this->db->prepare("SELECT id, name, cpf_cnpj, email, password, type FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new User(...$result) : null;
    }

    public function findByEmail(string $email): ?User {
        $stmt = $this->db->prepare("SELECT id, name, cpf_cnpj, email, password, type FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new User(...$result) : null;
    }

    public function save(User $user): bool {
        $stmt = $this->db->prepare("INSERT INTO users (name, cpf_cnpj, email, password, type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $user->name, $user->cpf_cnpj, $user->email, $user->password, $user->type);
        return $stmt->execute();
    }
}
