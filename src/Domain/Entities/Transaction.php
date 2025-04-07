<?php

namespace Domain\Entities;

class Transaction {
    public function __construct(
        public int $id,
        public int $idPayer,
        public int $idPayee,
        public float $value,
        public string $created_at
    ) {}
}
