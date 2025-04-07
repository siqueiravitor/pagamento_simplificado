<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Transaction;
use Domain\Repositories\TransactionRepository;
use mysqli;

class TransactionRepositoryImpl implements TransactionRepository {
    public function __construct(private mysqli $db) {}

    public function create(Transaction $transaction): bool {
        $stmt = $this->db->prepare("INSERT INTO transactions (id_payer, id_payee, value) VALUES (?, ?, ?)");
        $stmt->bind_param("iid",  $transaction->idPayer, $transaction->idPayee, $transaction->value);
        return $stmt->execute();
    }

    public function findAll(): array {
        $result = $this->db->query("SELECT id, id_payer as idPayer, id_payee as idPayee, value, created_at FROM transactions");
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = new Transaction(...$row);
        }
        return $rows;
    }
}
