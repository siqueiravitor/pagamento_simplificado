<?php

namespace Domain\Repositories;

use Domain\Entities\Wallet;

interface WalletRepository {
    public function findByUserId(int $userId): ?Wallet;
    public function save(Wallet $wallet): bool;
}
