<?php

namespace Domain\Repositories;

use Domain\Entities\Transaction;

interface TransactionRepository {
    public function create(Transaction $transaction): bool;
    public function findAll(): array;
}
