<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Wallet;
use Domain\Repositories\WalletRepository;
use mysqli;

class WalletRepositoryImpl implements WalletRepository {
    public function __construct(private mysqli $db) {}

    public function findByUserId(int $id_user): ?Wallet {
        $stmt = $this->db->prepare("SELECT id_user, balance FROM wallets WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new Wallet(...$result) : null;
    }

    public function save(Wallet $wallet): bool {
        $stmt = $this->db->prepare("UPDATE wallets SET balance = ? WHERE id_user = ?");
        $stmt->bind_param("di", $wallet->balance, $wallet->id_user);
        return $stmt->execute();
    }
}
